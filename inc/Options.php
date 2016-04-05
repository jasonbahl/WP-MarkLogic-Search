<?php
/*
 * This file is part of marklogic/wp-search
 *
 * @package     MarkLogic\WpSearch
 * @license     http://opensource.org/licenses/GPL-2.0 GPL-2.0+
 */

namespace MarkLogic\WpSearch;

class Options extends Hooks
{
    const SETTING = 'ml_wpsearch_settings';

    public static function getOptions()
    {
        return get_option(self::SETTING) ?: array();
    }

    public static function replaceSearch()
    {
        $opts = static::getOptions();
        return !empty($opts['replace_search']) && !empty(self::getSearchPage());
    }

    public static function getSearchPage()
    {
        $opts = static::getOptions();
        return isset($opts['search_page']) ? $opts['search_page'] : null;
    }

    public function hook()
    {
        add_action('admin_init', array($this, 'register'));
        // see http://codex.wordpress.org/Function_Reference/register_post_type#show_in_menu
        // for why the priority here is so low (early)
        add_action('admin_menu', array($this, 'addPage'), 1);
    }

    public function register()
    {
        register_setting(
            self::SETTING,
            self::SETTING,
            array($this, 'clean')
        );
        add_settings_section(
            'default',
            __('Connection Options', 'marklogic'),
            '__return_false',
            self::SETTING
        );
        add_settings_section(
            'search',
            __('Search', 'marklogic'),
            '__return_false',
            self::SETTING
        );

        $fields = array(
            'host'      => __('Host', 'marklogic'),
            'port'      => __('Port', 'marklogic'),
            'username'  => __('Username', 'marklogic'),
        );
        foreach ($fields as $fn => $label) {
            $id = self::idFor($fn);
            add_settings_field($id, $label, array($this, 'textInput'), self::SETTING, 'default', array(
                'label_for' => $id,
                'field'     => $fn,
            ));
        }
        $pid = self::idFor('password');
        add_settings_field(
            $pid, 
            __('Password', 'marklogic'),
            array($this, 'passwordInput'),
            self::SETTING,
            'default',
            array(
                'label_for' => $pid,
                'field'     => 'password',
            )
        );

        add_settings_field(
            $spid = self::idFor('search_page'),
            __('Search Page', 'marklogic'),
            array($this, 'dropdownPages'),
            self::SETTING,
            'search',
            array(
                'label_for' => $spid,
                'field' => 'search_page',
            )
        );
        add_settings_field(
            $sid = self::idFor('replace_search'),
            __('Replace WordPress Search', 'marklogic'),
            array($this, 'checkboxInput'),
            self::SETTING,
            'search',
            array(
                'label_for' => $sid,
                'field' => 'replace_search',
            )
        );
    }

    public function clean($dirty)
    {
        $clean = array();
        foreach (array('host', 'username', 'password') as $fn) {
            $clean[$fn] = isset($dirty[$fn]) ? sanitize_text_field($dirty[$fn]) : null;
        }
        $clean['port'] = isset($dirty['port']) ? filter_var($dirty['port'], FILTER_VALIDATE_INT) : null;
        $clean['replace_search'] = empty($dirty['replace_search']) ? false : true;
        $clean['search_page'] = empty($dirty['search_page']) ? null : absint($dirty['search_page']);

        return $clean;
    }

    public function addPage()
    {
        $page = add_options_page(
            __('MarkLogic Search', 'marklogic'),
            __('MarkLogic Search', 'marklogic'),
            'manage_options',
            'ml-wpsearch',
            array($this, 'showPage')
        );

        add_action("load-{$page}", array($this, 'loadPage'));
    }

    public function loadPage()
    {
        do_action('ml_wpsearch_load_settings_page');
    }

    public function showPage()
    {
        ?>
        <div class="wrap">
            <h1><?php _e('MarkLogic Search Settings', 'marklogic'); ?></h1>
            <?php do_action('ml_wpsearch_before_settings_form'); ?>
            <form method="POST" action="<?php echo admin_url('options.php'); ?>">
                <?php
                settings_fields(self::SETTING);
                do_settings_sections(self::SETTING);
                submit_button(__('Save', 'marklogic'));
                ?>
            </form>
            <?php do_action('ml_wpsearch_after_settings_form'); ?>
        </div>
        <?php
    }

    public function textInput(array $args)
    {
        $opts = self::getOptions();
        self::showInput(
            'text',
            $args['label_for'],
            isset($opts[$args['field']]) ? $opts[$args['field']] : null,
            array('class' => 'regular-text')
        );
    }

    public function passwordInput(array $args)
    {
        $opts = self::getOptions();
        self::showInput(
            'password',
            $args['label_for'],
            isset($opts[$args['field']]) ? $opts[$args['field']] : null,
            array('class' => 'regular-text')
        );
    }

    public function checkboxInput(array $args)
    {
        $opts = self::getOptions();
        self::showInput(
            'checkbox',
            $args['label_for'],
            1,
            empty($opts[$args['field']]) ? array() : array('checked' => 'checked')
        );
    }

    public static function dropdownPages(array $args)
    {
        $opts = self::getOptions();
        wp_dropdown_pages(array(
            'selected'  => isset($opts['search_page']) ? $opts['search_page'] : null,
            'name' => $args['label_for'],
            'id' => $args['label_for'],
            'show_option_none' => 'None',
        ));
    }

    private static function showInput($type, $id, $value, array $attributes=[])
    {
        $attr = array();
        foreach ($attributes as $k => $v) {
            $attr[] = sprintf('%s="%s"', tag_escape($k), esc_attr($v));
        }

        printf(
            '<input type="%1$s" id="%2$s" name="%2$s" value="%3$s" %4$s />',
            esc_attr($type),
            esc_attr($id),
            esc_attr($value),
            implode(' ', $attr)
        );
    }

    private static function idFor($fn)
    {
        return sprintf('%s[%s]', self::SETTING, $fn);
    }
}
