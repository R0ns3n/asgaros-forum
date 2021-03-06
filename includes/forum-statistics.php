<?php

if (!defined('ABSPATH')) exit;

class AsgarosForumStatistics {
    public static function showStatistics() {
        global $asgarosforum;

        // Check if this functionality is enabled.
        if ($asgarosforum->options['show_statistics']) {
            $data = self::getData();
            echo '<div id="statistics">';
                echo '<div id="statistics-header">';
                    echo '<strong class="dashicons-before dashicons-chart-line">'.__('Statistics', 'asgaros-forum').'</strong>';
                echo '</div>';
                echo '<div id="statistics-body">';
                    self::renderStatisticsElement(__('Topics', 'asgaros-forum'), $data->topics, 'dashicons-before dashicons-editor-alignleft');
                    self::renderStatisticsElement(__('Posts', 'asgaros-forum'), $data->posts, 'dashicons-before dashicons-format-quote');
                    self::renderStatisticsElement(__('Views', 'asgaros-forum'), $data->views, 'dashicons-before dashicons-visibility');
                    self::renderStatisticsElement(__('Users', 'asgaros-forum'), $data->users, 'dashicons-before dashicons-groups');
                    do_action('asgarosforum_statistics_custom_element');
                echo '</div>';
                do_action('asgarosforum_statistics_custom_content_bottom');
                echo '<div class="clear"></div>';
            echo '</div>';
        }
    }

    public static function getData() {
        global $asgarosforum;
        $queryTopics = "SELECT COUNT(id) FROM {$asgarosforum->tables->topics}";
        $queryPosts = "SELECT COUNT(id) FROM {$asgarosforum->tables->posts}";
        $queryViews = "SELECT SUM(views) FROM {$asgarosforum->tables->topics}";
        $data = $asgarosforum->db->get_row("SELECT ({$queryTopics}) AS topics, ({$queryPosts}) AS posts, ({$queryViews}) AS views");
        $users = count_users();
        $data->users = $users['total_users'];
        return $data;
    }

    public static function renderStatisticsElement($title, $data, $iconClass) {
        echo '<div class="statistics-element">';
            echo '<div class="element-number '.$iconClass.'">'.$data.'</div>';
            echo '<div class="element-name">'.$title.'</div>';
        echo '</div>';
    }
}
