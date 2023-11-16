<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header>
     <nav class="menubar">
          <div class="logo">
               <img src="img/favicon.ico" alt="">
               <a class="title-link" href="Home.php">WDA Livraria</a>
          </div>
          <div class="links">
               <div class="link">
                    <img src="img/dashboard.png" alt="" class="links_icons">
                    <a href="Home.php" class="<?php echo ($current_page == 'Home.php') ? 'selected' : ''; ?>">Dashboard</a>
               </div>
               <div class="link">
                    <img src="img/usuarios.png" alt="" class="links_icons">
                    <a href="User.php" class="<?php echo ($current_page == 'User.php') ? 'selected' : ''; ?>">Usuários</a>
               </div>
               <div class="link">
                    <img src="img/livros.png" alt="" class="links_icons">
                    <a href="Book.php" class="<?php echo ($current_page == 'Book.php') ? 'selected' : ''; ?>">Livros</a>
               </div>
               <div class="link">
                    <img src="img/editoras.png" alt="" class="links_icons">
                    <a href="Publisher.php" class="<?php echo ($current_page == 'Publisher.php') ? 'selected' : ''; ?>">Editoras</a>
               </div>
               <div class="link">
                    <img src="img/alugueis.png" alt="" class="links_icons">
                    <a href="Rental.php" class="<?php echo ($current_page == 'Rental.php') ? 'selected' : ''; ?>">Aluguéis</a>
               </div>
          </div>
          <div class="dropdown">
               <button onclick="toggleDropdown()">Menu</button>
               <ul class="dropdown-content" id="dropdownContent">
                    <li><a href="#" class="selected">Dashboard</a></li>
                    <li><a href="User.php" id="<?php echo ($current_page == 'User.php') ? 'pageTitle' : ''; ?>">Usuários</a></li>
                    <li><a href="Book.php" id="<?php echo ($current_page == 'Book.php') ? 'pageTitle' : ''; ?>">Livros</a></li>
                    <li><a href="Publisher.php" id="<?php echo ($current_page == 'Publisher.php') ? 'pageTitle' : ''; ?>">Editoras</a></li>
                    <li><a href="Rental.php" id="<?php echo ($current_page == 'Rental.php') ? 'pageTitle' : ''; ?>">Aluguéis</a></li>
               </ul>
          </div>
          <a href="php/logout.php" id="sair-btn"><button class="btn btn-outline-danger" id="botao-sair" type="submit">SAIR</button></a>
     </nav>
</header>