# Opérations à effectuer sur le thème enfant

## Vidéo
A voir ici


## Changement de dossiers
Les "parts" se trouvent à présent dans le dossier parts/ et non plus layouts/
modifier <?php get_template_part( 'layouts/template', 'share' ); ?> par <?php get_template_part( 'parts/template', 'share' ); ?>

Les templates de pages ont été déplacés dans le dossier page-templates pour plus de lisibilité 
/!\ Attention : il faut donc réassocier chaque gabarit

## Changement de parts name
La parts "partager" a été renommée en share
La parts "ilsfontlactus" a été renommée en testimonial

## Nouveaux Widget
Deux nouveaux widgets sont apparus :
- Footer
- Top Bar

Ils ne sont pour le moment pas exploiter mais peuvent l'être dans un thème enfant

## Renommage des options
Les options de citéo ont été renommé sous la forme de "opt_MODULE_OPTIONNAME" il faut donc repasser sur tous les fichiers des thèmes enfants qui appelent un get_field('XXXX', 'option') pour respecter la nouvelle nomenclature

## Refactoring du fichier functions.php
Un système de smart-include a été mis en place, le fichier ne doit plus comporter de code à l'exception des require_once 
Toutes les customs functions sont dans le dossier inc/ voir le fichier functions.php pour le détail
Ce système supporte nativement la surchage par le thème enfant de tout fichier (complet)

## Nouveau fonctionnement du menu
Le plugin menu doit être retiré manuellement (via git)
- @voir http://howto.inovawork.net/git/submodules/ (supprimer un submodule)

A présent tout passe par la gestion des pages et l'usage du plugin Nested Pages (Arborescence) qui créé un réplica de menu (nommée Nested Pages) dans les menus natifs de WordPress
Nous pouvons gérer des liens internes/externes

Le template header-menu.php a été fortement impacté, à reporter dans le thème enfant

## Ajout de nouveaux menus
Deux nouveaux menus 
- main (à utiliser impérativement, annule et remplace le plugin menu)
- top (non utilisé pour le moment mais peut l'être dans le thème enfant)


## Styles modifés

Retirer le style dans la feuille style principale : 
.portrait-img img {
	border-radius: 50%;
	height: x;
}