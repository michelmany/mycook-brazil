const list_status = {
    'CREATED'  : 'Pedido Criado',
    'WAITING'  : 'Aguardando Pagamento',
    'PAID'     : 'Pago',
    'NOT_PAID' : 'Cancelado',
    'RECERTED' : 'Reembolsado'
};

export default {
    formatStatus : (status) => {
        return _.get(list_status, status)
    }
};