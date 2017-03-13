# ScholarEvents - Sistema Gerenciador de Eventos Acadêmicos

O ScholarEvents é uma espécie de CMS para gerenciar eventos acadêmicos. Foi desenvolvido para facilitar escolas, faculdades e universidades a gerenciar minicursos, palestras e visitas técnicas online.

## CARACTERISTICAS

### SITE DO EVENTO
 - Página com Logo, titulo e descrição do evento academico
 - Tela de acesso para aluno e administrador
 - Widgets adicionados pelo administrador
 - Página para cada subevento com logo, descrição e anexos
 - Listagem de todos os cursos e palestras por subevento
 - Formulário de inscrição dos alunos onlines
 - Pagina com todos os arquivos anexos para download
 - Cronograma esquematico com todos os minicursos e palestras
 - Menu principal com itens adicionados pelo administrador


### AREA DO ALUNO
 - Plataforma para Seleção de minicurso ou palestra por subevento
 - Lista de todos os minicursos e palestras daquele subevento
 - Informações detalhadas sobre o minicurso, incluindo o horário
 - Verificação de choque entre o horário do aluno e quantidade máxima na sala
 - Listagem de todos os minicursos que o aluno está inscrito
 - Horário Completo do aluno
 - Capacidade de baixar Certificado em PDF dos seus cursos

### AREA DO ADMINISTRADOR
 - Deixar o site fora do ar (em manutenção)
 - Alterar a Senha do Administrador
 - Alterar o Esquema de Cores do Site
 - Baixar modelo de certificado em PNG ou PDF
 - Enviar plano de fundo para compor do Certificado
 - Alterar alguns textos que apareceram no certificado
 - Alterar Titulo, Logo e Descrição do site
 - Adicionar banners rotativos ao site
 - Adicionar códigos HTML em duas áreas do site
 - Gerenciar Links do menu principal
 - Modificar datas inicial, final, inscrições e bloqueio
 - Gerenciar quais salas serão usadas no evento
 - Adicionar professores e alunos
 - Criar subeventos do tipo minicurso, palestra ou visita tecnica
 - Adicionar Titulo, descrição, logo e anexos aos subeventos
 - Adicionar minicursos ou palestras por subevento
 - Gerenciar os minicursos, palestras e visitas tecnicas
 - Previsão de choques de horário entre minicursos

## REQUISITOS
 - Servidor Web Apache com PHP5.2 ou superior
 - Sevidor MySQL

## INSTALAÇÃO
1) Crie um banco de dados no mysql, obtenha o nome do host, user, senha e banco.

2) Na pasta www do seu webserver (htdocs para Xampp) execute o comando abaixo:

    git clone http://github.com/ailtonbsj/scholarevents scholarevents
   
3) Caso use linux altere as permissões para ficar igual ao windows:

    chmod 777 -R scholarevents
   
4) Acesse seu site em http://seudominio/scholarevents e preencha os dados necessários.

5) Após a instalação ser completada acesse a área do administrador:
   
    login: admin
    senha: admin

## Telas

![tela1] (https://ailtonbsj.files.wordpress.com/2017/01/01.png?w=395&h=316)


![tela2] (https://ailtonbsj.files.wordpress.com/2017/01/02.png?w=394)


![tela3] (https://ailtonbsj.files.wordpress.com/2017/01/screenshot-from-2017-02-14-16-32-41.png?w=390&h=272)
