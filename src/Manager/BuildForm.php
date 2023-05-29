<?php

namespace DaBuild\Manager;

class BuildForm
{

    public function BuildForm()
    {
        $conn = DbManager::getInstance();
        $table_name = static::TABLE;
        $database_name = DB_NAME;

// requête pour récupérer le nombre de colonnes
        $sql = "SELECT count(COLUMN_NAME) as count FROM information_schema.COLUMNS 
        WHERE table_name = '" . $table_name . "'
        AND table_schema = '" . $database_name . "'
        AND COLUMN_NAME NOT LIKE '%\_at'
        AND COLUMN_NAME NOT LIKE '%\_date'
        AND COLUMN_NAME NOT LIKE '%id'";

        $result = $conn->query($sql);
        $row = $result->fetch();
        $column_count = $row["count"];

// requête pour récupérer les noms des colonnes
        $sql = "SELECT COLUMN_NAME as column_name FROM information_schema.COLUMNS 
        WHERE table_name = '" . $table_name . "'
        AND table_schema = '" . $database_name . "'
        AND COLUMN_NAME NOT LIKE '%\_at'
        AND COLUMN_NAME NOT LIKE '%\_date'
        AND COLUMN_NAME NOT LIKE '%id'";

        $result = $conn->query($sql);
        $column_names = array();
        while ($row = $result->fetch()) {
            $column_names[] = $row["column_name"];
        }

// créer un formulaire automatiquement


        echo '<main class="Container_main Main">
    <h1 class="Main_title">Création automatisé d\'un formulaire</h1>';

        var_dump($column_count);
        var_dump($column_names);
        echo '<form method="POST"
          class="form_container">
        <fieldset class="fieldset">
            <legend>legend</legend>';
        for ($i = 0; $i < $column_count; $i++) {

            // Modification de la string de la bdd
            $labelToLower = strtolower($column_names[$i]);
            $labelForUser = ucfirst(str_replace('_', ' ', $labelToLower));

            echo '
                    <div class="elements">
                        <label for="' . $labelToLower . '">' . $labelForUser . '</label>
                        <input 
                        required 
                        type="text" 
                        id="firstname" 
                        name="field_' . $labelToLower . '" id="' . $labelToLower . '">
                    </div>';
        }

        echo '</fieldset>';
        echo '
        <div class="elements submit">
            <input type="submit" name="form_' . $table_name . '" value="Envoyer">
        </div>';
        echo '</form>';
    }

}