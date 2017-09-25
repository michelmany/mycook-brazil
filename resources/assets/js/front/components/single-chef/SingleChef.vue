<template>
    <div class="row">
      <!-- Cardápio -->
      <div class="col-md-12 col-lg-8">
          <cardapio :chef-id="seller.seller.id"></cardapio>
      </div>
      <!-- Carrinho -->
      <div class="col-md-12 col-lg-4 hidden-md-down">
          <cart :chef-name="seller.name" :chef-moip-id="moip.moipId"></cart>
      </div>
    </div>
</template>


<script>
  import Cardapio from './Cardapio.vue'
  import Cart from './Cart.vue'

  export default {
      props: ['seller', 'moip'],
      components: {
        Cardapio, Cart
      }
  }
</script>
