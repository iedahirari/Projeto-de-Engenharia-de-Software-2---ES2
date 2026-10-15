<?php
// Endereço antigo da busca de servidores: agora a busca fica em Servidores.php
header('Location: Servidores.php?' . http_build_query(['busca' => $_GET['pesquisar'] ?? '']), true, 301);
