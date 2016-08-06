# Opérations à effectuer sur le thème enfant
* Le fil d'ariane est désormais dans le header.php, il va falloir cleaner tous les templates overwrités, en enlevant le fil d'ariane de chacun d'eux et en remettant le fil d'ariane dans le header
* Du style par defaut à été rajouté sur le .section-breadcrumb. Bien vérifier que le fil d'ariane reste cohérent avec le reste
* La plupart des templates ont subi des changements de DOM, il serait préférable de mettre à jour les templates overwrité pour respecter une cohérence.
* Les paddings autour du layout-main ont également changé, attention qu'il sont toujours correct lors du checkout. Il n'y a plus de stripe/stripe-inner sur le layout-main ou son conteneur enfant.
* Les tags n'ont plus la classe meta par defaut mais la classe "tags", attention de reporter le style
* Tous les templates single-* et page.php ont une nouvelle architecture, il faut les refaire.
* Les filtres des pages de listing ont également été mise à jour. Il faut reporter les modifications.
* --La maj doit se faire en preprod avant d'être reporté en prod--

# Opérations à effectuer en back office
* Si le plugin ressources est mis à jour, le format de date stockées en BDD à changer, il faudra donc réenregister chaque ressources pour enregistrer le bon format de date
* Si il y a des problèmes de tailles de thumbnails sur le trombinoscope, faire un regenerate thumbnails
* La variation logo-retina vient d'être rajouté, pensez à faire un regenerate surtout si vous voulez utiliser votre logo en retina. Attention également, du css à été rajouté sur le logo par defaut, il faut vérifier que ça ne cause pas de changement sur chaque site.
* Une nouvelle variation à été créé : citeo-half. Pensez à regenerate thumbnail.