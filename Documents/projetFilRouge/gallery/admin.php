<?php

require './gallery/settings.php';
require './gallery/_lib_/translator_class.php';
$action_status_message = '';
$translator = new translator($settings['lang']);

// <<<<<<<<<<<<<<<
// ADMIN ACTIONS (Available when logged in)
// >>>>>>>>>>>>>>>
if (isset($_GET['delete'])) {
    $delete_this = 'gallery/'.$_GET['delete'];
    if (!is_dir($delete_this)) {
        if (file_exists($delete_this)) {
            // echo 'thumbnails/thumb-'.$_GET['delete'];exit();
            if (!simple_delete($delete_this)) {
                $action_status_message = '<p>' . $translator->string('L\'image a bien été supprimée');
            } else {
                $action_status_message = '<p>' . $translator->string('Supprimée l\'image :');
                $delete_this_thumb = str_lreplace('/', '/thumb-', $delete_this);
                simple_delete('gallery/thumbnails/'.$delete_this_thumb);// Delete thumbnail
            }
        } else {
            $action_status_message = '<p>' . $translator->string('L\'image n\'existe pas.');
        }
    } else {
        if (!simple_delete($delete_this)) {
            $action_status_message = '<p>' . $translator->string('Problèmes de permissions de dossier ou la catégorie n\'existe pas, veuillez contacter l\'administrateur');
        } else {
            $action_status_message = '<p>' . $translator->string('Supprimer la catégorie : ');
        }
        simple_delete('thumbnails/'.$delete_this);
    }
} elseif (isset($_POST['add_category'])) {
    if (preg_match("/^[a-zæøåÆØÅ0-9 ]+$/i", $_POST['add_category'])) {
        $add_category = $_POST['add_category'];
        $add_category = trim($_POST['add_category']);
        $add_category = space_or_dash(' ', $add_category); // Convert space to dash
        $add_category = strtolower($add_category);
        $search  = array(0,1,2,3,4,5,6,7,8,9);
        $replace = array('zero', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf');
        $add_category = str_replace($search, $replace, $add_category);        
        $add_category = './gallery/'.$add_category;
        if (!file_exists($add_category)) {
            mkdir($add_category, 0777);
            chmod($add_category, 0777); // We need to change permissions of the directory using chmod
            // after creating the directory, on some hosts
            $action_status_message = '<p>' . $translator->string('Créer une catégorie (pas d\'espaces!):') .' <b>'. $_POST['add_category'] .'</b></p>';
        } else {
            $action_status_message = '<p><b>'.$_POST['add_category'] .'</b> '. $translator->string('Cette catégorie existe déjà ou possède des chiffres, les chiffres sont interdits') . '</p>';
        }
    } else {
        $action_status_message = '<p>' . $translator->string('Nom de catégorie invalide (Caractère spéciaux, chiffres ou espaces mis en cause ?)') .' <b>'. $_POST['add_category'] .'</b></p>';
    }
} elseif ((isset($_GET['category'])) && (isset($_GET['set_preview_image']))) {
    // SET CATEGORY PREVIEW
    $thumbs_directory = 'gallery/thumbnails/' . $_GET['category'];
    
    if (file_exists($thumbs_directory . '/' . $category_json_file)) {
        $category_data = json_decode(file_get_contents($thumbs_directory . '/'. $category_json_file), true);
        $category_data['preview_image'] = 'thumb-'.$_GET['set_preview_image'];
    } else {
        $category_data = array('preview_image' => 'thumb-'.$_GET['set_preview_image']);
    }
    
    $category_data = json_encode($category_data);
    file_put_contents($thumbs_directory . '/' . $category_json_file, $category_data);
    
    $action_status_message = '<p>'.$translator->string('L\'image de prévisualisation de catégorie à changer dans la catégorie ') .'<b>'.$_GET['category'].'</b></p>';
}
if (!empty($action_status_message)) {
    $action_status_message = '<div id="action_status_message">' . $action_status_message . '</div>';
}


// <<<<<<<<<<<<<<<
// Show Upload Form if logged in
// >>>>>>>>>>>>>>>
$categories = list_dirs();
$select_category = '<select name="category">';
foreach ($categories as &$value) {
    if ((isset($_SESSION["selected_category"])) && ($_SESSION["selected_category"] == $value)) {
        $selected=" selected";
    } else {
        $selected = '';
    }
    if (!isset($ignored_categories_and_files["$value"])) {
        $select_category .= '<option value="'.$value.'"'.$selected.'>'.space_or_dash('-', $value).'</option>';
    }
}
$select_category .= '</select>';

$HTML_article_content = $action_status_message;
$HTML_article_content .= '
<div class="flexbox">
  <section class="column">
    <h2>'.$translator->string("Ajouter une image :").'</h2>
    <form action="index.php?page=upload" method="post" enctype="multipart/form-data" id="uploadForm">
      <label>'.$translator->string("Ajouter une image :").'</label>
      <input type="file" name="fileToUpload" id="fileToUpload">
      <label>'.$translator->string("Le mettre dans la catégorie:").'</label>'. $select_category.'
      <button class="button" onClick="uploadFile()" type="button">Upload</button>
    </form>
  </section>
  <section class="column">
    <h2>'.$translator->string("Créer une catégorie :").'</h2>
    <form action="./index.php?page=admin" method="post" enctype="multipart/form-data" id="add_categoryForm">
      <label>'.$translator->string("Nom de la catégorie (sans espaces ni chiffres ni caractères spéciaux) :").'</label>
      <input type="text" name="add_category">
      <input type="submit" class="button" value="'.$translator->string("Créer").'">
    </form>
  </section>
</div>';

$HTML_navigation = '<li><a href="index.php?page=galerie">'.$translator->string('Accueil galerie').'</a></li>';
$HTML_navigation .= '<li><a href="index.php?page=galerie">'.$translator->string('Catégories').'</a></li>';
$HTML_navigation = '<ol class="flexbox">'.$HTML_navigation.'</ol>';

// :::Functions:::
function space_or_dash($replace_this='-', $in_this)
{
    if ($replace_this=='-') {
        return preg_replace('/([-]+)/', ' ', $in_this);
    } elseif ($replace_this==' ') {
        return preg_replace('/([ ]+)/', '-', $in_this);
    }
}
function list_dirs()
{
    $item_arr = array_diff(scandir('gallery/'), array('..', '.'));
    foreach ($item_arr as $key => $value) {
        if (!is_dir('gallery/' . $value)) {
            unset($item_arr["$key"]);
        }
    }
    return $item_arr;
}
function str_lreplace($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);
    if ($pos !== false) {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}
function simple_delete($file_or_dir)
{
    if (is_writable($file_or_dir)) { // Check if directory/file is writeable (required to delete file)
    if (is_dir($file_or_dir)) { // If directory, check for subdirectories
      $objects = scandir($file_or_dir); // Check for contained directories and files
      foreach ($objects as $object) {
          if (($object !== '.') && ($object !== '..')) {
              if (is_dir($file_or_dir.'/'.$object)) { // Handle subdirectories too (if any)
            simple_delete($file_or_dir.'/'.$object); // If dealing with a subdirectory, perform another simple_delete()
              } else {
                  if (is_writable($file_or_dir.'/'.$object)) {
                      unlink($file_or_dir.'/'.$object);
                  }
              }
          }
      }
        rmdir($file_or_dir);
        return true;
    } else {
        unlink($file_or_dir); // simple_delete() also works on single files
    }
    } else {
        return false;
    }
}

require 'gallery/templates/'.$template.'/admin_template.php';
