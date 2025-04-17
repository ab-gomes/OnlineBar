<?php
try {
    $db = new PDO('sqlite:' .__DIR__. '/../db/onlinebar.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("
        CREATE TABLE bebidas (
            idBebidas INT PRIMARY KEY IDENTITY(1,1),
            nome VARCHAR NOT NULL,
            descricao VARCHAR,
            preco REAL NOT NULL,
            imagem VARCHAR(255) NOT NULL
        );

        INSERT INTO bebidas (nome, descricao, preco, imagem) VALUES
        ('Cerveja Heineken', 'Long neck gelada 330ml', 6.90, 'heineken.jpg'),
        ('Vinho Tinto Chileno', 'Garrafa 750ml', 49.90, 'vinho_tinto.jpg'),
        ('Whisky Jack Daniel’s', 'Garrafa 1L - Old No. 7', 129.90, 'jack.jpg');
    ");

    echo "Banco de dados criado e populado com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao criar banco: " . $e->getMessage();
}
?>