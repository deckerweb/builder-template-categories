<?php
// Focused regression harness: WordPress hooks/API doubles, real bundled catalogs.
define('ABSPATH', __DIR__);
$hooks = array();
$admin = false;
function add_filter($hook, $callback, $priority = 10, $args = 1) { global $hooks; $hooks[$hook][$priority][] = array($callback, $args); }
function add_action($hook, $callback, $priority = 10, $args = 1) { add_filter($hook, $callback, $priority, $args); }
function apply_filters($hook, $value, ...$args) { global $hooks; $groups = $hooks[$hook] ?? array(); ksort($groups); foreach ($groups as $callbacks) foreach ($callbacks as [$callback, $count]) $value = $callback(...array_slice(array_merge(array($value), $args), 0, $count)); return $value; }
function current_user_can($cap) { return true; }
function get_current_screen() { return null; }
function post_type_exists($type) { return $type !== "missing"; }
function wp_unslash($value) { return $value; }
function is_admin() { return $GLOBALS['admin']; }
function sanitize_key($s) { return preg_replace('/[^a-z0-9_\-]/', '', strtolower($s)); }
function esc_attr($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); }
function esc_url($s) { return (string) $s; }
function __($s, $domain = '') { return $GLOBALS['messages'][$s] ?? $s; }
function _x($s, $context, $domain = '') { return $GLOBALS['messages'][$context . chr(4) . $s] ?? $s; }
function esc_attr__($s, $domain = '') { return esc_attr(__($s, $domain)); }
function register_taxonomy($name, $types, $args) { $GLOBALS['registered'] = $args; }
class Response {
    private $data;
    function __construct($data) { $this->data = $data; }
    function get_data() { return $this->data; }
    function set_data($data) { $this->data = $data; }
}
class Request {
    private $type;
    function __construct($type) { $this->type = $type; }
    function get_param($key) { return $key === 'type' ? $this->type : null; }
}
function same($actual, $expected, $case) { if ($actual !== $expected) throw new Exception($case . ': ' . var_export($actual, true)); }
$repo = dirname(__DIR__);
require $repo . '/includes/functions-global.php';
require $repo . '/includes/string-switcher.php';
require $repo . '/includes/run-integrations.php';
require $repo . '/includes/register-taxonomy.php';
add_filter('btc/filter/integrations/all', function($all) {
    foreach (array('wp_block' => 'block', 'gp_elements' => 'element', 'test_pattern' => 'pattern') as $type => $label) {
        $all[$type] = array('post_type' => $type, 'template_label' => $label, 'label' => $label, 'submenu_hook' => '', 'admin_url' => '');
    }
    return $all;
});
$taxonomy = (object) array('name' => 'builder-template-category', 'object_type' => array('wp_block', 'gp_elements', 'test_pattern'));
foreach (array('de_DE', 'de_DE_formal', 'en_US') as $locale) {
    $messages = $locale === 'en_US' ? array() : (require $repo . '/languages/builder-template-categories-' . $locale . '.l10n.php')['messages'];
    $admin = false;
    ddw_btc_register_templates_taxonomy();
    same($registered['labels']['name'], $locale === 'en_US' ? 'Builder Categories' : 'Builder-Kategorien', $locale . ' REST default');
    same(apply_filters('btc/filter/string/default_content_type', 'Custom'), 'Custom', 'preserve supplied fallback');
    foreach (array('wp_block' => 'Block', 'gp_elements' => 'Element', 'test_pattern' => 'Pattern') as $type => $content) {
        $response = new Response(array('name' => $registered['labels']['name'], 'labels' => (object) $registered['labels'], 'slug' => $taxonomy->name));
        $data = apply_filters('rest_prepare_taxonomy', $response, $taxonomy, new Request($type))->get_data();
        $expected = $locale === 'en_US' ? 'Builder Categories' : 'Builder-Kategorien';
        same($data['name'], $expected, $locale . ' ' . $type);
        same($data['labels']['name'], $expected, 'panel label');
        same($data['slug'], $taxonomy->name, 'stable slug');
    }
    $admin = true; $_GET = array('post_type' => 'wp_block');
    ddw_btc_register_templates_taxonomy();
    same($registered['labels']['name'], $locale === 'en_US' ? 'Builder Categories' : 'Builder-Kategorien', 'classic admin label');
    $admin = false;
}
$messages = array();
foreach (array(null, 'unknown', array('wp_block')) as $type) {
    $response = new Response(array('name' => 'Original'));
    same(ddw_btc_rest_taxonomy_labels($response, $taxonomy, new Request($type))->get_data(), array('name' => 'Original'), 'unresolved type');
}
$other = (object) array('name' => 'category');
$response = new Response(array('name' => 'Native category'));
same(ddw_btc_rest_taxonomy_labels($response, $other, new Request('wp_block'))->get_data(), array('name' => 'Native category'), 'other taxonomy');
$response = new Response(array('slug' => $taxonomy->name, 'labels' => array('name' => 'Old')));
$data = ddw_btc_rest_taxonomy_labels($response, $taxonomy, new Request('wp_block'))->get_data();
same(array_keys($data), array('slug', 'labels'), '_fields name omitted');
same(array_keys($data['labels']), array('name'), 'nested _fields');
$response = new Response(array());
same(ddw_btc_rest_taxonomy_labels($response, $taxonomy, new Request('wp_block'))->get_data(), array(), 'HEAD/empty response');
add_filter('btc/filter/taxonomy/labels', function($labels) { $labels['name'] = 'Custom Categories'; return $labels; });
$response = new Response(array('name' => 'Old'));
same(ddw_btc_rest_taxonomy_labels($response, $taxonomy, new Request('wp_block'))->get_data()['name'], 'Custom Categories', 'existing label filter');
add_filter('btc/filter/integrations/all', function($all) {
    $all['invalid'] = array('post_type' => array('wp_block'));
    $all['missing'] = array('post_type' => 'missing', 'template_label' => 'template', 'label' => 'Missing', 'submenu_hook' => '', 'admin_url' => '');
    return $all;
});
same(isset(ddw_btc_get_integrations()['invalid']), false, 'malformed extension metadata');
same(isset(ddw_btc_get_integrations()['missing']), false, 'missing post type');
same($registered['capabilities']['assign_terms'], 'edit_theme_options', 'restricted assignment');
same($registered['show_in_menu'], false, 'no positional menu deletion needed');
echo "PASS: translated admin/REST labels, fallback, request isolation, fields and custom filters\n";
