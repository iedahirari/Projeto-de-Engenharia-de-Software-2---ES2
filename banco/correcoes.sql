-- Correções no banco bdservidores.
-- Rode depois de importar bdservidores.sql e antes de usar o crawler com --banco.

USE bdservidores;

-- tb_servidores ---------------------------------------------------------------
-- rendimentos era DOUBLE e recebia "1.715,26" como texto: o MySQL gravava 1.715
-- (perdendo os centavos). Agora é DECIMAL e o crawler envia 1715.26.
-- cargo tinha 30 caracteres, mas o portal tem cargos com até 40.
-- rgf passa a ser UNIQUE para o crawler atualizar em vez de duplicar.
ALTER TABLE `tb_servidores`
  MODIFY `nome` varchar(100) NOT NULL,
  MODIFY `cargo` varchar(100) NOT NULL,
  MODIFY `rendimentos` decimal(12,2) NOT NULL,
  ADD UNIQUE KEY `uk_servidores_rgf` (`rgf`);

-- tb_vereadores ---------------------------------------------------------------
-- O caminho das fotos tinha quebras de linha e a pasta com "f" minúsculo,
-- o que não funciona em servidores Linux (que diferenciam maiúsculas).
UPDATE `tb_vereadores`
  SET `imagem` = REPLACE(REPLACE(REPLACE(`imagem`, '\r', ''), '\n', ''), 'imgs/fotoVereadores/', 'imgs/FotoVereadores/');
UPDATE `tb_vereadores` SET `imagem` = 'imgs/FotoVereadores/Diego.png' WHERE `imagem` = 'imgs/FotoVereadores/diego.png';
UPDATE `tb_vereadores` SET `imagem` = 'imgs/FotoVereadores/Jorge.jpg' WHERE `imagem` = 'imgs/FotoVereadores/jorge.jpg';
