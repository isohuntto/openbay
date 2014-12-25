Openbay
=======
Nós, a equipe que trouxe pra você o [isoHunt](https://isohunt.to) e [oldpiratebay.org](http://oldpiratebay.org), estamos trazendo pra você o próximo passo na evolução do torrent. O código fonte do The Pirate Bay.

Sites de torrent como isoHunt e The Pirate Bay nos deu lições que seria um crime ignorar.
Sites de torrent são alvos fáceis. O código aberto do Pirate Bay vai dar a qualquer um com mínimo de conhecimento de 
como sites e equipamentos básicos de servidores funcionam a oportunidade de criar uma cópia do TPB em seu próprio 
domínio.

Instalação
=======

**Passo 1. Baixe o código.**

Faça o download da versão mais recente do motor em openbay.isohunt.to ou na página do GitHub.

**Passo 2. Suba o código para um servidor de sua escolha.**

Suba o código fonte para um servidor de sua preferência seguindo o guia de hospedagem 
(normalmente há uma ferramenta chamada CPanel) ou apenas use o FTP.

**Passo 3. Descompacte o código na pasta do servidor(opcional)**

Esse passo é opcional. Depende do seu servidor, alguns servidores descompactam automaticamente, alguns você deve fazer isso manualmente.

**Passo 4. Defina o ambiente de hospedagem(opcional)**

*Apache*

Sua opção está **disponível por padrão** no pacote fonte original. Você pode vê-lo em `conf/example.htaccess`

*Nginx*

Essa configuração está disponível no pacote original em `/conf/example.nginx.conf`

*Sphinx(modo avançado)*

[Instruções aqui](https://github.com/isohuntto/openbay/wiki/sphinx)

*MySQL(modo avançado)*

Antes do assistente ser executado, você precisa criar uma base de dados, o esquema da base de dados será criado pelo
assistente. Dump está em `/src/protected/data/schema.mysql.sql`

**Passo 5. Assistente**

Parabéns! Agora você pode abrir seu domínio com qualquer navegador e seguir o guia fornecido lá. Por padrão, você vai
precisar inserir o título da página que vai aparecer em todas suas páginas.

[Instruções detalhadas aqui](https://github.com/isohuntto/openbay/wiki/shared-hosting-guide)

Como contribuir?
=======
Relate problemas, envie *pull requests* para corrigir os problemas, ou para sugerir novas funcionalidades, devidamente documentadas e sumarizadas (de preferência faça pedidos que possuam a funcionalidade implementada).

**Sinta se livre para contribuir com o projeto da maneira que quiser!**
