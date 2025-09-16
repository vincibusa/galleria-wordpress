<?php
/**
 * Ottimizzazioni specifiche per hosting SiteGround
 * Galleria Adalberto Catanzaro Theme
 */

// Security: Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Gestione errori specifica per hosting condiviso
 */
class Galleria_Hosting_Optimizer {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->init_hooks();
    }
    
    private function init_hooks() {
        // Hook per ottimizzazioni hosting
        add_action('init', array($this, 'optimize_for_hosting'), 1);
        add_action('wp_loaded', array($this, 'check_memory_usage'));
        
        // Solo per admin
        if (is_admin()) {
            add_action('admin_init', array($this, 'admin_optimizations'));
            add_action('admin_notices', array($this, 'hosting_notices'));
        }
        
        // Gestione errori fatali
        register_shutdown_function(array($this, 'handle_fatal_errors'));
    }
    
    /**
     * Ottimizzazioni specifiche per hosting
     */
    public function optimize_for_hosting() {
        // Previeni timeout
        if (!ini_get('safe_mode')) {
            @set_time_limit(300);
        }
        
        // Ottimizza memory usage
        if (function_exists('memory_get_usage')) {
            $current_memory = memory_get_usage(true);
            $memory_limit = $this->get_memory_limit();
            
            if ($current_memory > ($memory_limit * 0.8)) {
                // Se siamo vicini al limite, forza garbage collection
                if (function_exists('gc_collect_cycles')) {
                    gc_collect_cycles();
                }
            }
        }
        
        // Disabilita alcune funzionalità su hosting condiviso se necessario
        if ($this->is_shared_hosting()) {
            $this->disable_heavy_features();
        }
    }
    
    /**
     * Controllo uso memoria
     */
    public function check_memory_usage() {
        if (function_exists('memory_get_usage')) {
            $memory_usage = memory_get_usage(true);
            $memory_limit = $this->get_memory_limit();
            $usage_percentage = ($memory_usage / $memory_limit) * 100;
            
            // Log se l'uso della memoria è alto
            if ($usage_percentage > 80) {
                error_log(sprintf(
                    'Galleria Theme: High memory usage detected - %.2f%% (%s of %s)',
                    $usage_percentage,
                    size_format($memory_usage),
                    size_format($memory_limit)
                ));
            }
        }
    }
    
    /**
     * Ottimizzazioni per admin
     */
    public function admin_optimizations() {
        // Riduci query su pagine admin
        if (!wp_doing_ajax()) {
            remove_action('admin_print_styles', 'wp_resource_hints', 1);
            remove_action('admin_print_scripts', 'wp_resource_hints', 1);
        }
        
        // Disabilita alcune funzioni non critiche in admin
        if (isset($_GET['page']) && strpos($_GET['page'], 'galleria') === false) {
            // Rimuovi hook non necessari per altre pagine admin
            remove_action('admin_bar_menu', 'galleria_smtp_admin_bar', 999);
        }
    }
    
    /**
     * Notice per problemi di hosting
     */
    public function hosting_notices() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Controlla configurazione hosting
        $issues = $this->check_hosting_configuration();
        
        if (!empty($issues)) {
            echo '<div class="notice notice-warning is-dismissible">';
            echo '<h4>Galleria Theme - Avvisi Hosting</h4>';
            foreach ($issues as $issue) {
                echo '<p>' . esc_html($issue) . '</p>';
            }
            echo '</div>';
        }
    }
    
    /**
     * Gestione errori fatali
     */
    public function handle_fatal_errors() {
        $error = error_get_last();
        
        if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_RECOVERABLE_ERROR])) {
            // Log errore fatale
            error_log(sprintf(
                'Galleria Theme Fatal Error: %s in %s on line %d',
                $error['message'],
                $error['file'],
                $error['line']
            ));
            
            // Se siamo nell'admin, mostra messaggio user-friendly
            if (is_admin() && !wp_doing_ajax()) {
                $this->show_admin_error_message();
            }
        }
    }
    
    /**
     * Controlla se siamo su hosting condiviso
     */
    private function is_shared_hosting() {
        // Alcuni indicatori di hosting condiviso
        $indicators = [
            isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'siteground') !== false,
            function_exists('apache_get_modules') && !in_array('mod_rewrite', apache_get_modules()),
            ini_get('max_execution_time') < 60,
            $this->get_memory_limit() < (128 * 1024 * 1024) // Meno di 128MB
        ];
        
        return count(array_filter($indicators)) > 1;
    }
    
    /**
     * Disabilita funzionalità pesanti su hosting condiviso
     */
    private function disable_heavy_features() {
        // Riduci revisioni post
        if (!defined('WP_POST_REVISIONS')) {
            define('WP_POST_REVISIONS', 3);
        }
        
        // Disabilita alcune query non essenziali
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'rsd_link');
    }
    
    /**
     * Ottieni limite memoria in bytes
     */
    private function get_memory_limit() {
        $limit = ini_get('memory_limit');
        if ($limit == -1) {
            return PHP_INT_MAX;
        }
        
        $limit = trim($limit);
        $last = strtolower(substr($limit, -1));
        $value = (int)$limit;
        
        switch ($last) {
            case 'g': $value *= 1024;
            case 'm': $value *= 1024;
            case 'k': $value *= 1024;
        }
        
        return $value;
    }
    
    /**
     * Controlla configurazione hosting
     */
    private function check_hosting_configuration() {
        $issues = array();
        
        // Controlla memory limit
        $memory_limit = $this->get_memory_limit();
        if ($memory_limit < (256 * 1024 * 1024)) {
            $issues[] = 'Memory limit troppo basso per tema complesso. Raccomandato: almeno 256MB.';
        }
        
        // Controlla execution time
        $max_execution_time = ini_get('max_execution_time');
        if ($max_execution_time > 0 && $max_execution_time < 60) {
            $issues[] = 'Execution time troppo basso. Raccomandato: almeno 60 secondi.';
        }
        
        // Controlla se le funzioni necessarie sono disponibili
        $required_functions = ['curl_init', 'mail', 'gd_info'];
        foreach ($required_functions as $func) {
            if (!function_exists($func)) {
                $issues[] = "Funzione PHP mancante: $func. Alcune funzionalità potrebbero non funzionare.";
            }
        }
        
        return $issues;
    }
    
    /**
     * Mostra messaggio errore admin
     */
    private function show_admin_error_message() {
        if (!headers_sent()) {
            status_header(500);
        }
        
        $message = '
        <div style="padding: 20px; font-family: -apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Oxygen-Sans,Ubuntu,Cantarell,\'Helvetica Neue\',sans-serif;">
            <h2>Errore del Tema Galleria</h2>
            <p>Si è verificato un errore tecnico. Questo può essere dovuto a limitazioni dell\'hosting.</p>
            <p><strong>Soluzioni da provare:</strong></p>
            <ul>
                <li>Contatta il supporto hosting per aumentare i limiti PHP</li>
                <li>Disabilita temporaneamente altri plugin</li>
                <li>Controlla i log degli errori del server</li>
            </ul>
            <p><small>Errore registrato nei log per diagnosi tecnica.</small></p>
        </div>';
        
        echo $message;
    }
}

// Inizializza ottimizzazioni
Galleria_Hosting_Optimizer::get_instance();

/**
 * Funzioni di utilità per hosting
 */

/**
 * Controllo rapido se siamo su SiteGround
 */
function galleria_is_siteground() {
    return isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'siteground') !== false;
}

/**
 * Ottimizza query per hosting condiviso
 */
function galleria_optimize_query($query) {
    if (!is_admin() && $query->is_main_query()) {
        // Limita posts per page su archivi per ridurre carico
        if ($query->is_archive()) {
            $query->set('posts_per_page', 6);
        }
        
        // Ottimizza query meta
        $query->set('update_post_meta_cache', false);
        $query->set('update_post_term_cache', false);
    }
}
add_action('pre_get_posts', 'galleria_optimize_query');

/**
 * Pulizia cache quando necessario
 */
function galleria_cleanup_cache() {
    if (function_exists('wp_cache_flush')) {
        wp_cache_flush();
    }
    
    if (function_exists('wp_cache_delete')) {
        // Pulisci cache specifiche del tema
        wp_cache_delete('galleria_option_*', '');
    }
}

// Pulisci cache periodicamente
if (!wp_next_scheduled('galleria_cleanup_cache')) {
    wp_schedule_event(time(), 'hourly', 'galleria_cleanup_cache');
}
add_action('galleria_cleanup_cache', 'galleria_cleanup_cache');