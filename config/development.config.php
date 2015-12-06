<?php

define('REQUEST_MICROTIME', microtime(true));
return array(
    'modules' => array(
        'ZFTool',
        'ZendDeveloperTools',
    ),
    'module_listener_options' => array(
        'config_cache_enabled' => false,
        'module_map_cache_enabled' => false,
    ),
);