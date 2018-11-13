# zenvia-php
Biblioteca PHP para consumo da api do Zenvia SMS API 2.0.

# Documentação API
https://zenviasms.docs.apiary.io/

# Serviços da API
* Envio de um único SMS   
// function authZenvia();
* Envio de vários SMSs simultaneamente  
// function send();
* Consulta Status de um SMS  
// function sendMany();
* Listar Novos SMS recebidos
// function searchSmsReceived();
* Consultar SMS recebidos por Período  
// function getStatus();
* Cancelamento de SMS agendado   
// function cancelSms();

# Callbacks da API (Webhook)
* Status de Entrega
* SMS Recebido
