<div class="search-engine">
    <form role="search" method="get" class="search-form" action="/basica/">
        <div class="input-group input-group-lg">
            <span class="input-group-addon"><i class="fa fa-search"></i></span>

            <input type="search" class="form-control" placeholder="Recherche" value="<?php echo get_search_query() ?>" name="s" title="Rechercher&nbsp;:">

            <button type="button" class="search-engine-help" data-container="body" data-toggle="popover" data-placement="bottom" data-title="Aide" data-trigger="hover" data-content="
            <ul>
                <li>La recherche est insensible à la casse,</li>
                <li>La recherche retourne 10 résultats par page,</li>
                <li>Les résultats contiennent tous les termes que vous recherchez,</li>
                <li>La recherche d'expressions peut être obtenue par l'utilisation des guillemets,</li>
                <li>Les mots peuvent être exclus en utilisant un signe moins (-), par exemple: libre-arbre.</li>
            </ul>" data-original-title="" title="">
            <i class="fa fa-question-circle"></i>
            </button>
            <span class="input-group-btn">
                <button class="btn btn-alert" type="submit"><i class="visible-sm visible-xs fa fa-search"></i><span class="visible-lg visible-md">Rechercher</span></button>
            </span>
        </div>
    </form>
</div>