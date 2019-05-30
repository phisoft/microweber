<?php
namespace Microweber\Utils\Backup;

use Microweber\Utils\Backup\Exporters\JsonExport;
use Microweber\Utils\Backup\Exporters\CsvExport;
use Microweber\Utils\Backup\Exporters\XmlExport;
use Microweber\Utils\Backup\Exporters\ZipExport;

class Export
{
	public $exportData = array();
	public $type = 'json';

	public function setType($type)
	{
		$this->type = $type;
	}
	
	public function setExportData($data) {
		$this->exportData = $data;
	}
	
	public function exportAsType($data)
	{
		$export = false;
		
		switch ($this->type) {
			case 'json':
				$export = new JsonExport($data);
				break;
				
			case 'csv':
				$export = new CsvExport($data);
				break;
				
			case 'xml':
				$export = new XmlExport($data);
				break;
				
			case 'zip':
				$export = new ZipExport($data);
				break;
			// Don't forget a break
		}
		
		if ($export) {
			return array(
				'success' => count($data, COUNT_RECURSIVE) . ' items are exported',
				'export_type' => $this->type,
				'data' => $export->start()
			);
		} else {
			return array(
				'error' => 'Export format not supported.'
			);
		}
	}

	public function getContent() {
		
		$readyContent = array();
		$tables = $this->_getTablesForExport();
		
		foreach($tables as $table) {
			$readyContent[$table] = $this->_getTableContent($table);
		}
		
		var_dump($readyContent); 
	}
	
	private function _getTableContent($table) {
		
		$exportFilter = array();
		$exportFilter['no_limit'] = 1;
		$exportFilter['do_not_replace_site_url'] = 1;
		
		return db_get($table, $exportFilter);
	}
	
	private function _skipTablesForExport() {
		
		$skipTables = array();
		$skipTables[] = 'modules';
		$skipTables[] = 'elements';
		$skipTables[] = 'users';
		$skipTables[] = 'log';
		$skipTables[] = 'notifications';
		$skipTables[] = 'content_revisions_history';
		$skipTables[] = 'module_templates';
		$skipTables[] = 'stats_users_online';
		$skipTables[] = 'stats_browser_agents';
		$skipTables[] = 'stats_referrers_paths';
		$skipTables[] = 'stats_referrers_domains';
		$skipTables[] = 'stats_referrers';
		$skipTables[] = 'stats_visits_log';
		$skipTables[] = 'stats_urls';
		$skipTables[] = 'system_licenses';
		$skipTables[] = 'users_oauth';
		$skipTables[] = 'sessions';
		
		return $skipTables;
	}

	private function _getTablesForExport() {
		
		$tablesList = mw()->database_manager->get_tables_list();
		$tablePrefix = mw()->database_manager->get_prefix();
		
		$readyTableList = array();
		foreach ($tablesList as $tableName) {
			
			if ($tablePrefix) {
				$tableName = str_replace_first($tablePrefix, '', $tableName);
			}
			
			if (in_array($tableName, $this->_skipTablesForExport())) {
				continue;
			}
			
			if (!empty($this->exportData)) {
				if (!in_array($tableName, $this->exportData['items'])) {
					continue;
				}
			}
			
			$readyTableList[] = $tableName;
			
		}
		
		return $readyTableList;
	}
	
	public function getContentX()
	{
		$export_only_ids = array();
		$content_ids = array();
		$categories_ids = array();
		$export_items = array();


		$skip_tables = array(
			"modules",
			"elements",
			"users",
			"log",
			"notifications",
			"content_revisions_history",
			'module_templates',
			"stats_users_online",
			"stats_browser_agents",
			"stats_referrers_paths",
			"stats_referrers_domains",
			"stats_referrers",
			"stats_visits_log",
			"stats_urls",
			"system_licenses",
			"users_oauth",
			"sessions"
		);

		$all_tables = array();
		$all_tables_with_rel = array();

		$all_tables_raw = mw()->database_manager->get_tables_list();
		$local_prefix = mw()->database_manager->get_prefix();

		foreach ($all_tables_raw as $k => $v) {
			if ($local_prefix) {
				$v = str_replace_first($local_prefix, '', $v);
				$all_tables[] = $v;
			} else {
				$all_tables[] = $v;
			}
		}
		$exported_tables_data = array();
		if ($all_tables) {

			foreach ($all_tables as $table) {
				if (! in_array($table, $skip_tables)) {
					$table_exists = mw()->database_manager->table_exists($table);
					if ($table_exists) {
						$db_export_params = array();
						$db_export_params['no_limit'] = 1;
						$db_export_params['do_not_replace_site_url'] = 1;

						$has_rel_field = false;

						$table_fields = mw()->database_manager->get_fields($table);

						if ($table_fields) {
							foreach ($table_fields as $table_field) {

								if (strtolower($table_field) == 'rel_type') {
									$has_rel_field = true;
								}
							}
						}

						if ($table == 'content') {
							if ($content_ids) {
								$rel_ids_implode = implode(',', $content_ids);

								$db_export_params['id'] = '[in]' . $rel_ids_implode;
							}
						} elseif ($table == 'categories') {
							if ($categories_ids) {
								$rel_ids_implode = implode(',', $categories_ids);

								$db_export_params['id'] = '[in]' . $rel_ids_implode;
							}
						} elseif ($has_rel_field) {

							$all_tables_with_rel[] = $table;
						}

						$table_content = array();
						$table_content2 = array();

						$table_content = db_get($table, $db_export_params);

						if (! $export_only_ids) {} else {

							if ($has_rel_field) {
								foreach ($export_only_ids as $rel_key => $rel_ids) {
									$rel_ids_implode = implode(',', $rel_ids);

									$db_export_params['rel_type'] = $rel_key;
									$db_export_params['rel_id'] = '[in]' . $rel_ids_implode;

									$table_content_rel = db_get($table, $db_export_params);

									if ($table_content_rel) {
										$table_content2 = array_merge($table_content2, $table_content_rel);
									}
								}
								// /$export_only_ids
							} else {
								// $table_conent = db_get($table, $db_export_params);
							}
						}

						if ($table_content) {
							if (isset($exported_tables_data[$table])) {
								$exported_tables_data[$table] = array_merge($exported_tables_data[$table], $table_content);
							} else {
								$exported_tables_data[$table] = $table_content;
							}
						}
						if ($table_content2) {
							$exported_tables_data[$table] = array_merge($exported_tables_data[$table], $table_content2);
						}
					}
				}
			}
		}
		array_walk_recursive($exported_tables_data, function (&$item) {
			if (is_string($item)) {
				$item = utf8_encode($item);
			}
		});

		return $this->exportAsType($exported_tables_data);
	}
}