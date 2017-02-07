<?php
/**
 * @since 1.0.0
 * @author Luca
 * @licence MIT
 */

$template = new lib\Template();

$table = [
    ['id' => 1, 'first_name' => 'Bruce', 'last_name' => 'Wayne', 'location' => 'Gotham City'],
    ['id' => 2, 'first_name' => 'Clarke', 'last_name' => 'Kent', 'location' => 'Metropilis'],
    ['id' => 3, 'first_name' => 'Oliver', 'last_name' => 'Queen', 'location' => 'Star City'],
    ['id' => 4, 'first_name' => 'Diana', 'last_name' => 'Prince', 'location' => 'Themyscira']
];

$template->assign('table', $table);
$template->display('templates/tables.phtml');