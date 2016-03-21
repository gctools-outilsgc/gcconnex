<?php

$brazilian = array(
	// general
	'group_tools:decline' => "Recusar",
	'group_tools:revoke' => "Cancelar",
	'group_tools:add_users' => "Adicionar usuários",
	'group_tools:in' => "em",
	'group_tools:remove' => "Remover",
	'group_tools:clear_selection' => "Remover seleção",
	'group_tools:all_members' => "Todos membros",
	'group_tools:explain' => "Explicação",
	
	'group_tools:default:access:group' => "Apenas membros do grupo",
	
	'group_tools:joinrequest:already' => "Cancelar requisição de entrada no grupo",
	'group_tools:joinrequest:already:tooltip' => "Você já solicitou entrada neste grupo, clique aqui para cancelar a requisição",
	
	// menu
	'group_tools:menu:mail' => "Enviar email para os membros",
	'group_tools:menu:invitations' => "Gerenciar convites",
	
	// plugin settings
	'group_tools:settings:invite:title' => "Opções de convite",
	'group_tools:settings:management:title' => "Opções gerais dos grupos",
	'group_tools:settings:default_access:title' => "Acesso padrão dos grupos",
	
	'group_tools:settings:admin_create' => "Limitar a criação de grupos a administradores do site",
	'group_tools:settings:admin_create:description' => "Definir esta opção para 'Sim' vai tornar impossível a criação de novos grupos por usuários normais do site.",
	
	'group_tools:settings:admin_transfer' => "Permitir transferência de proprietário dos grupos",
	'group_tools:settings:admin_transfer:admin' => "Apenas adminstradores do site",
	'group_tools:settings:admin_transfer:owner' => "Proprietários dos grupos e administadores",
	
	'group_tools:settings:multiple_admin' => "Permitir múltiplos proprietários",
	
	'group_tools:settings:invite' => "Permitir convite para todos os usuários (não apenas amigos)",
	'group_tools:settings:invite_email' => "Permitir convites por email",
	'group_tools:settings:invite_csv' => "Permitir convites por arquivo CSV",
	
	'group_tools:settings:mail' => "Permitir email para grupo (permite proprietários dos grupos enviar um email para todos os membros)",
	
	'group_tools:settings:listing' => "Aba padrão ao entrar na área de comunidades",
	
	'group_tools:settings:default_access' => "Qual deve ser o acesso padrão para o conteúdo nas comunidades do site",
	'group_tools:settings:default_access:disclaimer' => "<b>DISCLAIMER:</b> this will not work unless you have <a href='https://github.com/Elgg/Elgg/pull/253' target='_blank'>https://github.com/Elgg/Elgg/pull/253</a> applied to your Elgg installation.",
	
	'group_tools:settings:search_index' => "Permitir comunidades fechadas serem indexadas pelas ferramentas de busca",
	'group_tools:settings:auto_notification' => "Habilitar automaticamente notificações das comunidades para novos membros",
	'group_tools:settings:auto_join' => "Comunidades padrão para novos membros",
	'group_tools:settings:auto_join:description' => "Novos membros entrarão automaticamente nestas comunidades",
	
	// group invite message
	'group_tools:groups:invite:body' => "Olá %s,

%s convidou você para entrar na comunidade '%s'.
%s

Clique abaixo para visualizar seus convites:
%s",
		
	// group add message
	'group_tools:groups:invite:add:subject' => "Você foi adicionado na comunidade %s",
	'group_tools:groups:invite:add:body' => "Olá %s,

%s adicionou você para a comunidade %s.
%s

Para visualizar a comunidade, clique neste link:
%s",
	// group invite by email
	'group_tools:groups:invite:email:subject' => "Você foi convidado para a comunidade %s",
	'group_tools:groups:invite:email:body' => "Olá,

%s convidou você para entrar na comunidade %s em %s.
%s

Se você não tiver uma conta em %s por favor registre-se aqui
%s

Se já possuir uma conta, clique aqui para aceitar o convite
%s

Ainda é possivel entrar nos convites de comunidades e digitar o seguinte código:
%s",
	// group transfer notification
	'group_tools:notify:transfer:subject' => "A propriedade da comunidade %s foi transferida para você",
	'group_tools:notify:transfer:message' => "Olá %s,

%s transferiu para você a propriedade da comunidade %s.

Para visualizar a comunidade, clique neste link:
%s",
	
	// group edit tabbed
	'group_tools:group:edit:profile' => "Comunidade",
	'group_tools:group:edit:other' => "Outras opções",
	
	// admin transfer - form
	'group_tools:admin_transfer:title' => "Transferir propriedade da comunidade",
	'group_tools:admin_transfer:transfer' => "Transfer a propriedade da comunidade para",
	'group_tools:admin_transfer:myself' => "Eu",
	'group_tools:admin_transfer:submit' => "Transferir",
	'group_tools:admin_transfer:no_users' => "Nenhum membro ou amigo para transferir a comunidade.",
	
	// auto join form
	'group_tools:auto_join:title' => "Opções de comunidades padrão",
	'group_tools:auto_join:add' => "%sAdicionar esta comunidade%s para o grupo de comunidades padrão. Isso significa que novos usuários serão adicionados automaticamente nesta comunidade.",
	'group_tools:auto_join:remove' => "%sRemover esta comunidade%s do grupo de comunidades padrão. Isso significa que novos usuários não serão mais adicionados automaticamente nesta comunidade.",
	'group_tools:auto_join:fix' => "Para tornar todos os usuários do site membros desta comunidade, %sclique aqui%s.",
	
	// group admins
	'group_tools:multiple_admin:group_admins' => "Proprietários da comunidade",
	'group_tools:multiple_admin:profile_actions:remove' => "Remover proprietário",
	'group_tools:multiple_admin:profile_actions:add' => "Adicionar proprietário",
	
	'group_tools:multiple_admin:group_tool_option' => "Permitir proprietários da comunidade atribuirem outros proprietários",
	
	// cleanup options
	'group_tools:cleanup:title' => "Barra lateral",
	'group_tools:cleanup:description' => "Barra lateral da comunidade. Isto não tem efeito para proprietários da comunidade.",
	'group_tools:cleanup:owner_block' => "Limitar o bloqueio do proprietário",
	'group_tools:cleanup:owner_block:explain' => "O bloqueio do proprietário pode ser encontrado no topo da barra lateral, alguns links extras podem estar nesta área (examplo: atualizações RSS).",
	'group_tools:cleanup:actions' => "Você quer permitir usuários entrarem nesta comunidade",
	'group_tools:cleanup:actions:explain' => "Dependendo da configuração da comunidade, usuários pode entrar diretamente na comunidade ou requisitarem um convite.",
	'group_tools:cleanup:menu' => "Ocultar itens do menu lateral",
	'group_tools:cleanup:menu:explain' => "Ocultar os links do menu para diferetentes ferramentas da comunidade. Os usuários poderão apenas ter acesso às ferramentas usando os widgets da comunidade.",
	'group_tools:cleanup:members' => "Ocultar os membros da comunidade",
	'group_tools:cleanup:members:explain' => "Na página da comunidade existe uma lista com os membros da mesma. Habilitando esta opção irá ocultar esta lista.",
	'group_tools:cleanup:search' => "Ocultar busca no grupo",
	'group_tools:cleanup:search:explain' => "Na página da comunidade existe uma caixa de busca. Habilitando esta opção irá ocultar esta caixa",
	'group_tools:cleanup:featured' => "Mostrar comunidades em destaque",
	'group_tools:cleanup:featured:explain' => "Você pode escolher mostrar uma lista com as comunidades em destaque na página desta comunidade.",
	'group_tools:cleanup:featured_sorting' => "Como organizar as comunidades em destaque",
	'group_tools:cleanup:featured_sorting:time_created' => "Novas primeiro",
	'group_tools:cleanup:featured_sorting:alphabetical' => "Ordem alfabética",
	
	// group default access
	'group_tools:default_access:title' => "Acesso padrão da comunidade",
	'group_tools:default_access:description' => "Aqui você pode controlar como os novos conteudos da sua comunidade podem ser acessados.",
	
	// group notification
	'group_tools:notifications:title' => "Notificações da comunidade",
	'group_tools:notifications:description' => "Esta comunidade possui %s membros, destes %s habilitaram notificações de atividade neste grupo. Abaixo você pode mudar isto para todos os membros desta comunidade.",
	'group_tools:notifications:disclaimer' => "Com comunidades de muitos membros, isto pode demorar um pouco.",
	'group_tools:notifications:enable' => "Habilitar notificações para todos",
	'group_tools:notifications:disable' => "Desabilitar notificações para todos",
	
	// group profile widgets
	'group_tools:profile_widgets:title' => "Mostrar widgets da comunidade para não-membros",
	'group_tools:profile_widgets:description' => "Esta é uma comunidade fechada. Por padrão nenhum widget é mostrado para não-membros. Aqui você pode configurar se deseja mudar isto.",
	'group_tools:profile_widgets:option' => "Permitir não-membros visualizarem widgets na página da comunidade:",
	
	// group mail
	'group_tools:mail:message:from' => "Do grupo",
	
	'group_tools:mail:title' => "Enviar email para os membros da comunidade",
	'group_tools:mail:form:recipients' => "Número de destinatários",
	'group_tools:mail:form:members:selection' => "Selecionar membros individuais",
	
	'group_tools:mail:form:title' => "Assunto",
	'group_tools:mail:form:description' => "Mensagem",
	
	'group_tools:mail:form:js:members' => "Por favor selecionar pelo menos um membro para mandar a mensagem",
	'group_tools:mail:form:js:description' => "Por favor escreva uma mensagem",
	
	// group invite
	'group_tools:groups:invite:title' => "Convidar pessoas para este grupo",
	'group_tools:groups:invite' => "Convidar pessoas",
	
	'group_tools:group:invite:friends:select_all' => "Selecionar todos os amigos",
	'group_tools:group:invite:friends:deselect_all' => "Desselecionar todos os amigos",
	
	'group_tools:group:invite:users' => "Buscar pessoa(s)",
	'group_tools:group:invite:users:description' => "Digita um nome de uma pessoa e a selecione da lista",
	'group_tools:group:invite:users:all' => "Convidar todas as pessoas do site para a lista",
	
	'group_tools:group:invite:email' => "Usando endereço de email",
	'group_tools:group:invite:email:description' => "Digite um endereço de email válido e selecione da lista",
	
	'group_tools:group:invite:csv' => "Usando envio de arquivo CSV",
	'group_tools:group:invite:csv:description' => "Você pode enviar um arquivo CSV com os usuários.<br />O formato deve ser: nome;e-mail . Não deve possuir uma linha de cabeçalho.",
	
	'group_tools:group:invite:text' => "Nota pessoal (opcional)",
	'group_tools:group:invite:add:confirm' => "Tem certeza que deseja adicionar estes usuários diretamente?",
	
	'group_tools:group:invite:resend' => "Reenviar convites para usuários que já foram convidados",
	
	'group_tools:groups:invitation:code:title' => "Convite por email",
	'group_tools:groups:invitation:code:description' => "Se você recebei um convite para entrar na comunidade por email, você pode digitar o código aqui para aceitá-lo. Caso clique no link no email de convite, o código será inserido automaticamente para você.",
	
	// group membership requests
	'group_tools:groups:membershipreq:requests' => "Solicitações de entrada na comunidade",
	'group_tools:groups:membershipreq:invitations' => "Convites enviados ainda não aceitos",
	'group_tools:groups:membershipreq:invitations:none' => "Nenhum convite enviado pendente",
	'group_tools:groups:membershipreq:invitations:revoke:confirm' => "Tem certeza que deseja cancelar este convite",
	
	// group invitations
	'group_tools:group:invitations:request' => "Solicitações de entrada pendentes",
	'group_tools:group:invitations:request:revoke:confirm' => "Tem certeza que deseja cancelar sua solicitação de entrada na comunidade?",
	'group_tools:group:invitations:request:non_found' => "Não há solicitações de entrada pendentes neste momento",
	
	// group listing
	'group_tools:groups:sorting:alphabetical' => "Ordem alfabética",
	'group_tools:groups:sorting:open' => "Abertas",
	'group_tools:groups:sorting:closed' => "Fechadas",
	
	// actions
	'group_tools:action:error:input' => "Entrada inválida para esta ação",
	'group_tools:action:error:entities' => "As GUIDs dadas não resultaram entidades corretas",
	'group_tools:action:error:entity' => "A GUID dada não resultou em uma entidade correta",
	'group_tools:action:error:edit' => "Você não possui acesso à entidade dada",
	'group_tools:action:error:save' => "Ocorreu um erro ao salvar as configurações",
	'group_tools:action:success' => "Configurações salva com sucesso",
	
	// admin transfer - action
	'group_tools:action:admin_transfer:error:access' => "Você não tem permissão de transferir a propriedade desta comunidade",
	'group_tools:action:admin_transfer:error:self' => "Você não pode transferir a propriedade para você mesmo, você já é o proprietário",
	'group_tools:action:admin_transfer:error:save' => "Desculpe, um erro desconhecido ocorreu ao salvar a comunidade, por favor tente novamente",
	'group_tools:action:admin_transfer:success' => "Propriedade do grupo transferida com sucesso para %s",
	
	// group admins - action
	'group_tools:action:toggle_admin:error:group' => "A entrada dada não resulto em uma comunidade válida ou você não pode editar esta grupo ou o usuário não é um membro",
	'group_tools:action:toggle_admin:error:remove' => "Erro desconhecido ao remover propriedade do membro",
	'group_tools:action:toggle_admin:error:add' => "Erro desconhecido ao adicionar propriedade para o membro",
	'group_tools:action:toggle_admin:success:remove' => "Usuário foi removido do grupo de proprietários da comunidade com sucesso",
	'group_tools:action:toggle_admin:success:add' => "Usuário foi adicionado ao grupo de proprietários com sucesso",
	
	// group mail - action
	'group_tools:action:mail:success' => "Mensagem enviada com sucesso",
	
	// group - invite - action
	'group_tools:action:invite:error:invite'=> "Nenhuma pessoa foi convidada (%s convidadas, %s membros)",
	'group_tools:action:invite:error:add'=> "Nenhuma pessoa foi convidada (%s convidadas, %s membros)",
	'group_tools:action:invite:success:invite'=> "Convite enviado com sucesso para %s pessoas (%s já convidadas e %s já membros)",
	'group_tools:action:invite:success:add'=> "Convite enviado com sucesso para %s pessoas (%s já convidadas e %s já membros)",
	
	// group - invite - accept e-mail
	'group_tools:action:groups:email_invitation:error:input' => "Por favor digite o código do convite",
	'group_tools:action:groups:email_invitation:error:code' => "O código não é mais válido",
	'group_tools:action:groups:email_invitation:error:join' => "Erro desconhecido ao tentar entrar na comunidade %s, talvez você já seja um membro desta comunidade",
	'group_tools:action:groups:email_invitation:success' => "Você entrou na comunidade com sucesso",
	
	// group toggle auto join
	'group_tools:action:toggle_auto_join:error:save' => "Um erro ocorreu ao salvar as novas configurações",
	'group_tools:action:toggle_auto_join:success' => "Novas configurações salvas com sucesso",
	
	// group fix auto_join
	'group_tools:action:fix_auto_join:success' => "Membros das comunidades ajustados: %s novos membros, %s já eram membros e %s falhas",
	
	// group cleanup
	'group_tools:actions:cleanup:success' => "Configurações de limpeza ajustadas com sucesso",
	
	// group default access
	'group_tools:actions:default_access:success' => "Acesso padrão para a comunidade foi salva com sucesso",
	
	// group notifications
	'group_tools:action:notifications:error:toggle' => "Opção inválida",
	'group_tools:action:notifications:success:disable' => "Notificações para todos os membros desativadas com sucesso",
	'group_tools:action:notifications:success:enable' => "Notificações para todos os membros ativadas com sucesso",
	
	// Widgets
	// Group River Widget
	'widgets:group_river_widget:title' => "Atividade na comunidade",
	'widgets:group_river_widget:description' => "Mostra a atividade na comunidade em um widget",
	
	'widgets:group_river_widget:edit:num_display' => "Número de atividades",
	'widgets:group_river_widget:edit:group' => "Selecione uma comunidade",
	'widgets:group_river_widget:edit:no_groups' => "Você precisa ser um membro de pelo menos uma comunidade para usar este widget",
	
	'widgets:group_river_widget:view:not_configured' => "Este widget ainda não foi configurado",
	
	'widgets:group_river_widget:view:more' => "Atividade na comunidade '%s'",
	'widgets:group_river_widget:view:noactivity' => "Não foi encontrada nenhuma atividade.",
	
	// Group Members
	'widgets:group_members:title' => "Membros da comunidade",
	'widgets:group_members:description' => "Mostra os membros da comunidade",
	
	'widgets:group_members:edit:num_display' => "Quantos membros mostrar",
	'widgets:group_members:view:no_members' => "Nenhum membro da comunidade foi encontrado",
	
	// Group Invitations
	'widgets:group_invitations:title' => "Convites",
	'widgets:group_invitations:description' => "Mostra os convites pendentes",
	
	// Discussion
	"widgets:discussion:settings:group_only" => "Mostrar discussões apenas para comunidades que você é membro",
	'widgets:discussion:more' => "Ver mais discussões",
	"widgets:discussion:description" => "Mostrar últimas discussões",
	
	// Forum topic widget
	'widgets:group_forum_topics:description' => "Mostrar últimas discussões",
	
	// index_groups
	'widgets:index_groups:description' => "Mostrar as últimas comunidades",
	'widgets:index_groups:show_members' => "Mostrar número de membros",
	'widgets:index_groups:featured' => "Mostrar apenas comunidades em destaque",
	
	'widgets:index_group:filter:field' => "Filtrar comunidades",
	'widgets:index_group:filter:value' => "com valor",
	'widgets:index_group:filter:no_filter' => "Nenhum filtro",
	
	// Featured Groups
	'widgets:featured_groups:description' => "Mostrar uma lista aleatória com comunidades em destaque",
	'widgets:featured_groups:edit:show_random_group' => "Mostrar uma lista aleatória com comunidades que não estão em destaque",
	
	// group_news widget
	"widgets:group_news:title" => "Notícias dos grupos",
	"widgets:group_news:description" => "Mostrar últimos 5 blogs de várias comunidades",
	"widgets:group_news:no_projects" => "Nenhuma comunidade configurada",
	"widgets:group_news:no_news" => "Nenhum blog desta comunidade",
	"widgets:group_news:settings:project" => "Comunidade",
	"widgets:group_news:settings:no_project" => "Seleciona uma comunidade",
	"widgets:group_news:settings:blog_count" => "Número máximo de blogs",
	"widgets:group_news:settings:group_icon_size" => "Tamanho do ícone da comunidade",
	"widgets:group_news:settings:group_icon_size:small" => "Pequeno",
	"widgets:group_news:settings:group_icon_size:medium" => "Médio",
	
);

add_translation("pt_br", $brazilian);