<div class="user-data full-width">
    <div class="user-profile">
        <div id="username-dt" class="username-dt">
            <div id="usr-pic" class="usr-pic">
                <img src=<?php echo $_POST["foto"];?> alt="">
            </div>
        </div><!--username-dt end-->
        <div class="user-specs">
            Hola <h3><?php echo $_POST["nombre"];?></h3>
            <!--<span>¿Pongo algo aquí?Graphic Designer at Self Employed</span>-->
        </div>
    </div><!--user-profile end-->
    <ul class="user-fw-status">
        <!--<li>
            <h4>Following</h4>
            <span>34</span>
        </li>-->
        <li>
            <h4>Amistades</h4>
            <span id="amistades"></span>
        </li>
        <!--<li>
            ¿Pongo aquí todas las amistades de alguna manera?
        </li>
        <li>
            <a href="#" title="">View Profile</a>
        </li>-->
    </ul>
</div>
