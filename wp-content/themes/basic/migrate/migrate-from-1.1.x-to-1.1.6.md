# Opérations à effectuer sur le thème enfant
* Il faut mettre à jour le bouton affichant la recherche en mobile sur le fatmenu de cette manière :
header-menu.php
```
<button type="button" class="btn search-toggle">
    <i class="fa fa-search"></i> <!-- ou <i class="glyphicon glyphicon-search"></i> -->
</button>
```
par :
```
<a href="#layer-search-engine" class="btn search-toggle fm-search-trigger fm-trigger">
    <i class="fa fa-search"></i> <!-- ou <i class="glyphicon glyphicon-search"></i> -->
</a>
```
* Attention, suite à ce changement de DOM, il faut vérifier que le style du buton soit toujours correct.

* Il faut aussi modifier l.87 (header-menu.php)
```
<?php foreach($sub_levels as $sub_level): ?>
<div id="layer-<?=$sub_level->menu_item_parent; ?>" class="fm-layer">
```
par :
```
<?php $previous_parents = []; ?>
<?php foreach($sub_levels as $sub_level): ?>
<?php if(!in_array($sub_level->menu_item_parent, $previous_parents)): ?>
<div id="layer-<?=$sub_level->menu_item_parent; ?>" class="fm-layer">
    <?php $previous_parents[] = $sub_level->menu_item_parent; ?>
```
et l.117
```
<?php endforeach; ?>
```
par
```
<?php endif; ?>
<?php endforeach; ?>
```


# Opérations à effectuer en back office
* Aucune