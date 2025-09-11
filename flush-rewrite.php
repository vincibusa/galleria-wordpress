<?php
/**
 * Flush Rewrite Rules
 * Fix per far funzionare l'archivio /projects/
 */

// Include WordPress
if (!defined('ABSPATH')) {
    require_once('../../../../../wp-config.php');
}

if (!current_user_can('manage_options')) {
    die('Access denied');
}

// Force flush rewrite rules
flush_rewrite_rules();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Flush Rewrite Rules - Galleria Catanzaro</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f1f1f1; }
        .container { background: white; padding: 30px; border-radius: 8px; max-width: 800px; margin: 0 auto; }
        .success { background: #d1edff; border: 1px solid #bee5eb; color: #0c5460; padding: 15px; border-radius: 4px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Rewrite Rules Flushed</h1>
        
        <div class="success">
            <strong>✅ Fatto!</strong><br>
            Le regole di rewrite sono state rigenerate. Ora l'archivio /projects/ dovrebbe funzionare.
        </div>
        
        <h2>🔗 Test Links:</h2>
        <ul>
            <li><a href="<?php echo home_url('/projects/'); ?>" target="_blank">Projects Archive: /projects/</a></li>
            <li><a href="<?php echo admin_url('edit.php?post_type=project'); ?>" target="_blank">Manage Projects (Admin)</a></li>
            <li><a href="<?php echo admin_url('options-permalink.php'); ?>" target="_blank">Permalink Settings</a></li>
        </ul>
        
        <p><strong>Se ancora non funziona:</strong></p>
        <ol>
            <li>Vai in WordPress Admin → Impostazioni → Permalink</li>
            <li>Clicca "Salva modifiche" senza cambiare nulla</li>
            <li>Prova di nuovo il link /projects/</li>
        </ol>
    </div>
</body>
</html>