<?php
function adminer_object() {
    class AdminerSoftware extends Adminer {
        private $config;

        function __construct($config) {
            $this->config = $config;
        }

        function name() {
            // custom name in title and heading
            return $this->config['name'];
        }

        function permanentLogin() {
            // key used for permanent login
            return $this->config['permanentLogin'];
        }

        function credentials() {
            // server, username and password for connecting to database
            return $this->config['credentials'];
        }

        function database() {
            // database name, will be escaped by Adminer
            return $this->config['database'];
        }

        function login($login, $password) {
            // validate user submitted credentials
            return ($login == 'root' && $password == 'toor');
        }

        // function tableName($tableStatus) {
        //   // tables without comments would return empty string and will be ignored by Adminer
        //   return h($tableStatus['Comment']);
        // }
        //
        function fieldName($field, $order = 0) {
            return '<span title="' . h($field['comment']) . '">' . h($field['field']) . '</span>';
            // return h($field['field'] . ($field['comment'] ? "(" . $field['comment'] . ")" : ''));
            // only columns with comments will be displayed and only the first five in select
            // return ($order <= 5 && !preg_match('~_(md5|sha1)$~', $field['field']) ? h($field['comment']) : '');
        }

        // function css() {
        //     return 'adminer.css';
        // }

        /** Prints table list in menu
         * @param array result of table_status('', true)
         * @return null
         */
        function tablesPrint($tables) {
            echo "<ul id='tables'>" . script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");
            foreach ($tables as $table => $status) {
                $name = $this->tableName($status);
                if ($name != "") {
                    echo '<li>';
                    // echo '<a href="' . h(ME) . 'select=' . urlencode($table) . '"' . bold($_GET["select"] == $table || $_GET["edit"] == $table, "select") . ">" . lang('select') . "</a> ";
                    echo (support("table") || support("indexes")
                        ? '<a href="' . h(ME) . 'select=' . urlencode($table) . '"'
                        . bold(in_array($table, array($_GET["table"], $_GET["create"], $_GET["indexes"], $_GET["foreign"], $_GET["trigger"])), (is_view($status) ? "view" : "structure"))
                        . " title='" . lang('Show structure') . "'>$name</a>"
                        : "<span>$name</span>"
                    ) . "\n";
                }
            }
            echo "</ul>\n";
        }
    }

    return new AdminerSoftware(require 'config.php');
}

include './adminer.php';
