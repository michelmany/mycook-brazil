const list_status = {
    'CREATED'  : 'Pedido Criado',
    'WAITING'  : 'Aguardando Pagamento',
    'PAID'     : 'Pago',
    'NOT_PAID' : 'Cancelado',
    'RECERTED' : 'Reembolsado'
};

const delivery_status = {
	'0' : 'Aguardando',
	'1' : 'Encaminhando',
	'2' : 'Saiu para Entrega',
	'3' : 'Endereço não localizado',
	'4' : 'Entregue',
	'5' : 'Finalizado'  
}


export default {
    formatStatus: (status) => _.get(list_status, status),
    
    formatStatusDelivery: (status) => _.get(delivery_status, status)
};