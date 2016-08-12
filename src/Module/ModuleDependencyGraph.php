<?php

namespace Piccolo\Module;

/**
 * This class represents a module dependency graph to aid in generating the proper module load order.
 *
 * @internal
 * @package Foundation
 * @see https://en.wikipedia.org/wiki/Topological_sorting
 */
class ModuleDependencyGraph {
	/**
	 * @var array ['class' => string, 'object' => Module, 'after' => string[], 'before' => string[]]
	 */
	private $modules = [];

	/**
	 * @param Module $module
	 */
	public function addModule(Module $module) {
		$moduleClass = \get_class($module);
		$this->modules[$moduleClass] = [
			'class'  => $moduleClass,
			'object' => $module,
			//Modules that should be loaded after this one. Outgoing graph edges
			'after'  => [],
			//Modules that should be loaded before this one. Incoming graph edges.
			'before' => [],
		];
	}

	public function addModules(array $modules) {
		foreach ($modules as $module) {
			$this->addModule($module);
		}
	}

	/**
	 * Returns a GraphViz DOT graph to represent the circular dependency found. A PNG image can be generated using
	 * this command: `dot -Tpng input.dot output.png`
	 *
	 * @see https://en.wikipedia.org/wiki/DOT_(graph_description_language)
	 *
	 * @return string
	 */
	public function getDotGraph() : string {
		$escapeClassName = function(string $class) : string {
			return '"' . \str_replace('\\', '\\\\', $class) . '"';
		};

		$dotData = 'digraph modules {' . PHP_EOL;
		foreach ($this->modules as $moduleSpec) {
			$module = $moduleSpec['object'];
			if ($module instanceof OrderAwareModule) {
				foreach ($module->getModulesBefore() as $moduleBeforeClass) {
					$dotData .= '    ' . $escapeClassName($moduleBeforeClass) . ' -> ' .
						$escapeClassName($moduleSpec['class']) . ';' . PHP_EOL;
				}
				foreach ($module->getModulesAfter() as $moduleAfterClass) {
					$dotData .= '    ' . $escapeClassName($moduleSpec['class']) . ' -> ' .
						$escapeClassName($moduleAfterClass) . ';' . PHP_EOL;
				}
			} else {
				$dotData .= '    ' . $escapeClassName($moduleSpec['class']) . ';' . PHP_EOL;
			}
		}
		$dotData .= '}';

		return $dotData;
	}

	/**
	 * Returns a list of modules, sorted by dependencies.
	 *
	 * @return Module[]
	 *
	 * @throws CircularModuleLoadOrderDetectedException
	 */
	public function getSortedModuleList() : array {
		$moduleList = $this->modules;

		foreach ($moduleList as $moduleSpec) {
			$moduleClass = $moduleSpec['class'];
			$module      = $moduleSpec['object'];

			if ($module instanceof OrderAwareModule) {
				//All modules that should be loaded after this one
				foreach ($module->getModulesAfter() as $afterModuleClass) {
					if (\array_key_exists($afterModuleClass, $moduleList)) {
						$moduleList[$moduleClass]['after'][] = $afterModuleClass;
						$moduleList[$afterModuleClass]['before'][] = $moduleClass;
					}
				}
				//All modules that should be loaded before this one
				foreach ($module->getModulesBefore() as $afterModuleClass) {
					if (\array_key_exists($afterModuleClass, $moduleList)) {
						$moduleList[$moduleClass]['before'][] = $afterModuleClass;
						$moduleList[$afterModuleClass]['after'][] = $moduleClass;
					}
				}
			}
		}

		$sortedList = [];
		$noIncomingNodes = [];
		foreach ($moduleList as $moduleSpec) {
			$moduleSpec['after']  = \array_unique($moduleSpec['after']);
			$moduleSpec['before'] = \array_unique($moduleSpec['before']);
			if (empty($moduleSpec['before'])) {
				$noIncomingNodes[$moduleSpec['class']] = $moduleSpec;
			}
		}

		//Do the topological sorting (Kahn's algorithm)
		while (!empty($noIncomingNodes)) {
			$moduleSpec = array_shift($noIncomingNodes);
			\array_push($sortedList, $moduleSpec);
			unset($moduleList[$moduleSpec['class']]);

			foreach ($moduleSpec['after'] as $nextModuleKey => $nextModuleClass) {
				unset($moduleList[$nextModuleClass]['before'][
					\array_search($moduleSpec['class'], $moduleList[$nextModuleClass]['before'])
				]);
				if (empty($moduleList[$nextModuleClass]['before'])) {
					$noIncomingNodes[] = $moduleList[$nextModuleClass];
				}
				unset($moduleSpec['after'][$nextModuleKey]);
			}
		}

		foreach ($moduleList as $key => $remainingModuleSpec) {
			if (empty($remainingModuleSpec['before'])) {
				$sortedList[] = $moduleList[$remainingModuleSpec['class']];
				unset($moduleList[$key]);
			}
		}

		if (!empty($moduleList)) {
			throw new CircularModuleLoadOrderDetectedException($this->getDotGraph());
		} else {
			$result = [];
			foreach ($sortedList as $moduleSpec) {
				$result[] = $moduleSpec['object'];
			}
			return $result;
		}
	}
}