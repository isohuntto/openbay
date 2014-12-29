Openbay
=======
Nós, a equipe que trouxe pra você o https://isohunt.to e http://oldpiratebay.org apresentamos para você o próximo passo 
na evolução do torrent. O código fonte do The Pirate Bay.

Sites de torrent como Isohunt e The Pirate Bay nos deram lições que seria um crime ignorar.
Sites isolados de torrent são alvos fáceis. Este código vai dar a qualquer um com o mínimo de habilidades em TI e equipamento básico para servir sites web, a oportunidade de criar uma cópia do The Pirate Bay em seu próprio 
domínio.

Instalação
=======

**Passo 1. Baixe o código.**

Faça o download da versão mais recente do código em openbay.isohunt.to ou na página do GitHub.

**Passo 2. Suba o código para um servidor de sua escolha.**

Suba o código fonte para um servidor de sua preferência seguindo o guia de hospedagem 
(geralmente usando uma ferramenta tipo CPanel) ou use apenas o FTP.

**Passo 3. Descompacte o código na pasta do servidor(opcional)**

Esse passo é opcional. Depende do seu servidor, alguns servidores descompactam automaticamente, outros você tem que 
fazer isso manualmente.

**Passo 4. Defina o ambiente de hospedagem(opcional)**

*Apache*
Essa opção está disponível por padrão no pacote de código fonte original. Você pode vê-lo em `conf/example.htaccess`.

*Nginx*
Essa configuração está disponível no pacote original em `/conf/example.nginx.conf`

*Sphinx(modo avançado)*

[Instrução aqui](https://github.com/isohuntto/openbay/wiki/sphinx)

*MySQL(modo avançado)*
Antes do assistente ser executado, você precisa criar uma base de dados, o esquema da base de dados será criado pelo
assistente. Você pode acessar o dump aqui: `/src/protected/data/schema.mysql.sql`

**Passo 5. Assistente**
Parabéns! Agora você pode abrir seu domínio com qualquer navegador e seguir o guia fornecido lá. Como padrão você vai
precisar fornecer um título que será usado em todas as páginas do site.

[Instrução detalhada aqui](https://github.com/isohuntto/openbay/wiki/shared-hosting-guide)

Como contribuir?
=======
Relate problemas, envie "Pull Requests" para corrigir os problemas, ou para criar pedidos de implementação de recursos de forma resumida e documentada (de preferência junto com o codigo de implementação do recurso).

**Sinta se livre para contribuir com o projeto da maneira que quiser!**
