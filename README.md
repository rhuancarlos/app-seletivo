# INSCRIÇÕES DE CAMPANHAS
Projeto para inscrições de pessoas que queiram participar de campanhas da igreja.


### Recursos
<!-- * Painel com 4 stagios. -->
* Notificação de confirmação por e-mail
<!-- * Contador de vagas disponíveis -->
* Painel administrativo com emissor de relatórios por periodo.

### Importante 

> O Recurso de notificação de confirmação por e-mail utiliza a integração com o projeto mailjet. Após inclusão da biblioteca no projeto deve-se realizar a parametrização via painel administrativo do sistema o token e chave de integração, podendo ser habilitado ou não o envio da confirmação. Feita as devidas configuração será possível verificar via callback o retorno do envio da confirmação.


## Implementação 
1. Mailjet

> - Realizar Clone do projeto dentro da pasta **application/
https://gitlab.com/rhuanoliver/mailjet**
> - Habilitar a linha 2 do controller **Campanhas.php**
>- Acessar o painel administrativo **sistema.ibnfiladelfia.com.br** 
e configurar o token e senha de integração com a plataforma
