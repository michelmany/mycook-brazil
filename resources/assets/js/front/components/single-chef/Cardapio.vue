<template>
    <section class="cardapio">

        <vue-loading v-show="loading" type="bubbles" color="#F95700" :size="{ width: '50px', height: '50px' }" key="1"></vue-loading>

        <!-- implements filter by category -->

        <div class="d-flex flex-row-reverse">
            <div class="p-2 btn-group btn-group-sm" v-show="items.length > 0">
                <button class="btn btn-default" @click="filterCategories.orderBy = !filterCategories.orderBy">
                    <i class="fa" :class="{'fa-sort-alpha-asc': filterCategories.orderBy, 'fa-sort-alpha-desc': !filterCategories.orderBy}"></i>
                </button>
            </div>
        </div>

        <transition name="fade" mode="in-out">
        <div role="tablist" v-if="categories.length > 0 && items.length > 0">
            <b-card no-body class="mb-1" v-for="(category,index) in categories" :key="index" v-if="category.items.length > 0">
                <b-card-header header-tag="header" class="p-1" role="tab">
                    <div class="d-flex justify-content-end">
                        <div class="mr-auto p-2" style="line-height: 2.25">
                            {{ category.name.toUpperCase() }}
                        </div>
                        <div class="p-2">
                            <span class="p-2 badge badge-default">
                                {{ category.items.length >= 1 ?  category.items.length + ' produto(s)' : 'Vazio'  }}
                            </span>
                            <b-btn href="#" size="sm" v-b-toggle="'accordion_category_'+index" variant="secondary" v-on:click.native="filterProductByCategory(category)">
                                <i class="fa fa-plus" :class="{'fa-plus': filterCategories.collapse.id === '',
                                                       'fa-minus': filterCategories.collapse.id === category.id}">
                                </i>
                            </b-btn>
                        </div>
                    </div>
                </b-card-header>

                <b-collapse :data-category="category.id" :id="'accordion_category_'+index" accordion="my-accordion" role="tabpanel">
                    <b-card-body>
                        <!-- product filtered -->
                        <div class="cardapio__item" v-for="(item, index) in category.items" key="index" v-if="item.extras.length > 0">
                            <div class="row px-3">
                                <div class="col-md-5">
                                    <div v-if="item.photo" class="cardapio__image mb-3 mb-md-0" 
                                    v-lazy:background-image="item.photo_full_url"></div>
                                    <div v-else class="cardapio__image mb-3" style="background-image: url('/assets/img/no-image_01.jpg')"></div>
                                </div>
                                <div class="col-md-7">
                                    <div>
                                        <h5 class="cardapio__title text-uppercase">{{ item.name }}</h5>
                                        <div class="cardapio__desc">{{ item.desc }}</div>
                                        <span class="cardapio__readmore" @click="expandReadMore(index)">Ler mais...</span>

                                        <div>
                                            <span class="cardapio__serve badge badge-primary" v-if="item.serve > 0">
                                                Quantidade: Serve {{ item.serve }} {{ people(item.serve) }}</span>
                                        </div>
                                        <!-- To do: Pegar os dias que tem times setados e mostrar no span abaixo -->
                                        <div class="cardapio__time mt-3">Disponível nos dias: {{ dateRangeBadge(item) }}</div>
                                        <div class="cardapio__time">Hoje: {{ timeRangeAvailableForToday(item) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div class="col-md-12 px-0">
                                    <div class="cardapio__footer d-flex justify-content-between align-items-center flex-wrap mt-3">
                                        <div class="cardapio__price">R$ {{ item.price }}</div>
                                        <button class="btn btn-outline-primary text-uppercase" @click="openDaysOrAddToCart(item, index, $event)">{{ btnLabel }}</button>
                                    </div>
                                    <transition name="slide-fade" mode="in-out">
                                        <div class="cardapio__days" v-show="index == itemIndex" v-if="showDays">
                                            <p>Selecione o dia desejado</p>
                                            <li v-for="(weekDay, dayIndex) in item.extras" class="text-uppercase"
                                                v-bind:disabled="weekDay.quantity == 0 || pastTime(weekDay.time)"
                                                v-bind:class="{ disabled: weekDay.quantity == 0 || pastTime(weekDay.time) }"
                                                @click="selectDate(weekDay, dayIndex, index, item)">{{ weekDay.date }}</li>
                                        </div>
                                    </transition>
                                </div>
                            </div>
                        </div>
                        <!-- product filtered -->
                    </b-card-body>
                </b-collapse>
            </b-card>
        </div>
    </transition>
    
        <div v-if="noItemsToShow" key="message">
            <div class="alert alert-warning" role="alert">
                {{noItemTextMessage}}
            </div>
        </div>
        <!-- implements filter by category -->

        <sweet-modal ref="modalTime" :id="currentModalTime.index">
            <div class="text-uppercase mb-3">Você receberá o pedido no seu endereço</div>
            <!-- To do: adicionar component de trocar endereço direto no modal -->
            <div class="card mb-3">
                <div class="card-block">
                    <list-addresses></list-addresses>
                </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <h6 class="card-title text-uppercase">Escolha o horário para entrega</h6>
                    <h4 class="card-text">
                        <!-- <i class="fa fa-arrow-circle-o-left"></i> -->
                        <div class="form-group">
                            <select class="form-control" v-model="cartData.time">
                                <option disabled value="">Clique para selecionar</option>
                                <option v-for="time in selectedTimes" :value="time">{{ formatTime(time) }} ~ {{  formatTimeMore30(time) }}</option>
                            </select>
                        </div>
                        <!--<i class="fa fa-arrow-circle-o-right"></i>-->
                    </h4>
                </div>
            </div>

            <button slot="button" class="btn btn-submit-orange"
                    v-bind:disabled="cartData.time.length == 0"
                    v-bind:class="{ disabled: cartData.time.length == 0 }"
                    @click="continueToCart(currentModalTime.item, currentModalTime.index)">Continuar</button>
        </sweet-modal>

    </section>
</template>

<script>
    import { eventBus } from '../../app';
    import ListAddresses from '../utils/ListAddresses.vue'
    import vueLoading from 'vue-loading-template'
    import Moment from 'moment';
    import { extendMoment } from 'moment-range';
    import { HttpService } from '../../services/httpService';
    import {refreshAt} from '../../../painel/helpers/functions'

    const moment = extendMoment(Moment);
    let httpService = new HttpService();

    export default {
        components: { ListAddresses },
        data() {
            return {
                btnLabel: "Agendar entrega",
                noItemsToShow: false,
                noItemTextMessage: "Nenhum produto cadastrado no cardápio!",
                loading: false,
                showDays: false,
                isListFiltered: false,
                selectedTimes: [],
                itemIndex: '',
                now: '',
                items: [],
                selectedDateIndex: '',
                cartData: {
                    time: '',
                    date: '',
                    address: null
                },
                cartItems: [],
                pathname: window.location.pathname,
                cartStorage : {
                    items: [],
                    courier: {}
                },
                // filtered !
                categories: [],
                filterCategories : {
                    orderBy: false,
                    collapse: {
                        id: '',
                        target: ''
                    }
                },
                currentModalTime: {
                    index: null,
                    item: {}
                }
            }
        },
        props: ["chefId"],
        methods: {
            setNow() {
                this.now = moment().unix()
            },
            openDaysOrAddToCart(item, index, event) {
                if (this.isListFiltered == false) {
                    this.itemIndex = index;
                    this.showDays = true;
                } else {
                    this.showDays = false;
                    this.addItem(item, index);
                }

                // console.log(event)
            },
            selectDate(weekday, dayIndex, index, item = '') {
                this.setNow()
                this.selectedTimes = weekday.time;
                this.cartData.date = weekday.date;
                this.cartData.fulldate = weekday.fulldate;

                this.selectedDateIndex = dayIndex;

                // Current Modal
                this.currentModalTime.index = index;
                this.currentModalTime.item = item;

                // Fitler the time for today
                if(weekday.date == 'Hoje') {
                    this.filterTodayTime(weekday.time)
                }

                // Open Modal
                this.referenceProductIndex = index;
                this.$refs.modalTime.open(index)

                // Clear cart when user selects new date or time
                this.clearCart()
            },
            continueToCart(item, index) {
                this.$refs.modalTime.close(index)

                console.log('continueToCart')
                // Current Modal
                this.currentModalTime.index = null;
                this.currentModalTime.item = {};

                this.addItem(item, index);
            },
            addItem(item, index) {
//                console.log('addItem');
                let itemDescFormated = item.desc.length > 45 ? item.desc.substring(0, 45) + '...' : item.desc;

                const newItem = {
                    id: item.id,
                    name: item.name,
                    desc: itemDescFormated,
                    price: item.price,
                    availableQty: item.extras[this.selectedDateIndex].quantity,
                    qty: 1,
                    category_id: item.category_id
                };

                if(this.categories.length > 0) {
                    let _index = _.findIndex(this.categories, category => category.id === item.category_id);
                    let _indexItem = _.findIndex(this.categories[_index].items, product => product.id === item.id);
                    this.categories[_index].items.splice(_indexItem, 1)
                }

                this.cartItems.push(newItem);

                this.$bus.$emit('cartItems', this.cartItems, this.cartData, newItem, this.selectedDateIndex, this.selectedTimes);

                // Remove from array after add to the cart
                this.items.splice(index, 1);

                //Change message alert for no items available
                if (this.items.length == 0) {
                    this.noItemsToShow = true;
                    this.setNoItemsTextMessage();
                }

                //shows only the products available on this selected day 
                if (this.isListFiltered == false) {
                    this.FilterByDaySelected(item, index);
                }

            },
            FilterByDaySelected(item, index) {
                this.isListFiltered = true;
                this.showDays = false;

                // console.log("time selected: " + this.cartData.time)
                // console.log("Outside loop: " + item.name + " - index: " + index);
                this.items.forEach( (item, index) => {
                    // console.log("Inside loop: " + item.name + " - index: " + index);
                    item.extras.forEach( (extra) => {

                        if(this.cartData.date === extra.date && !_.includes(extra.time, this.cartData.time)) {
                            // console.log("Date:" + extra.date);
                            // console.log("removing item: " + item.name + " index: " + index);
                            this.removeProductCategoryById(item.id);
                        }

                        if(this.cartData.date === extra.date && extra.quantity === 0) {
                            // console.log("Date:" + extra.date);
                            // console.log("removing item: " + item.name + " index: " + index);
                            this.removeProductCategoryById(item.id);
                        }

                    })
                });

                //Change message alert for no items available
                if (this.items.length === 0) {
                    this.setNoItemsTextMessage();
                }
            },
            clearCart() {
                this.cartData.time = "";
                this.cartItems = [];
            },
            setNoItemsTextMessage() {
                this.noItemTextMessage = "Não há mais produtos disponíveis para " + this.cartData.date + ", com entrega entre " + this.formatTime(this.cartData.time) + " e " + this.formatTimeMore30(this.cartData.time) + ".";
            },
            orderingWeekDays() {

                this.items.forEach( (item, index) => {
                    if (item.extras.length > 0) {

                        // Crio um array com os dias da semana, com o primeiro dia sendo o dia atual (Hoje)
                        const weekRange = moment.range(moment(), moment().add(6, 'days'))
                        const ArrayWeek = Array.from(weekRange.by('days'))
                        let ArrayWeekFinal = ArrayWeek.map(d => d.format('ddd'))

                        // Ordeno meu array com os extras de acordo com a ordem do array com os dias da semana
                        item.extras.sort(function(a,b) {
                            return ArrayWeekFinal.indexOf(a.date) > ArrayWeekFinal.indexOf(b.date);
                        });

                        // Troco o nome do primeiro botão que é sempre "HOJE"
                        item.extras[0].date = "Hoje"

                    }
                })

            },
            getRangeTime() {
                this.items.forEach( (item, index) => {
                    item.extras.forEach( (extra, index) => {
                        const TimeRange = moment.range(moment(extra.start_time,'HH:mm'), moment(extra.end_time, 'HH:mm'));
                        const ArrayTimes = Array.from(TimeRange.by('hours', { step: 0.5 }))

                        let arrayTimesFinal = ArrayTimes.map(h => moment(h).add(index, 'days').format())

                        extra.time = arrayTimesFinal;
                        extra.fulldate = moment().add(index, 'days').format('ddd, DD/MM')

                        if(index == 0) {
                            extra.fulldate = moment().format('[Hoje], DD/MM')
                        } else if (index == 1) {
                            extra.fulldate = moment().add(index, 'days').format('[Amanhã], DD/MM')
                        }
                    })
                })
            },
            filterTodayTime(times) {
                var now = moment().add(1, 'hours').unix();
                this.selectedTimes = []
                times.forEach((time, index) =>  {
                    if (moment(time).unix() > now) {
                        this.selectedTimes.push(time)
                    }
                })
            },
            formatTime(time) {
                return moment(time).format('HH[h]mm')
            },
            formatTimeMore30(timeSelected) {
                return moment(timeSelected).add(30, 'm').format('HH[h]mm')
                // console.log(date)
            },
            timeRangeAvailableForToday(item) {
                var arr = item.extras[0].time;
                var todayTime = arr.slice(-1)[0]; //get the last time
                // console.log(todayTime);
                if (item.extras[0] && item.extras[0].quantity > 0 && moment(todayTime).unix() > this.now ) {
                    return item.extras[0].start_time + " às " + item.extras[0].end_time;
                }
                return "Indisponível";
            },
            dateRangeBadge(item) {
                var dateRange = [];
                item.extras.forEach((extra) => {
                    if(extra.quantity) {
                        dateRange.push(extra.date);
                    }
                })
                return dateRange.join(", ");
            },
            pastTime(time) {
                var todayTime = time.slice(-1)[0]; //get the last time
                if (moment(todayTime).unix() < this.now) {
                    return true
                }
                return false
            },
            getProducts() {
                this.loading = true;

                const _cart = { items: [], courier: {} };
                this.$bus.$on('getCartStorage', (storage) => {
                    _.forEach(storage.items, (item) => {
                        const index = _.find(this.cartStorage.items, e => e.id === item.id);
                        if(!index || index < 0){
                            _cart.items.push(item)
                        }
                    })
                    _cart.selectedDateIndex = storage.selectedDateIndex
                    _cart.selectedTimes = storage.selectedTimes
                    _cart.courier = storage.courier;
                })

                this.cartStorage = _cart

                axios.get('/get-products/' + this.chefId)
                    .then((res) => {
                        this.loading = false;
                        this.items = res.data;
                        this.removeItemNoExtra();
                        this.orderingWeekDays();
                        this.getRangeTime();
                        this.getCategories();
                    });
            },
            removeItemNoExtra() {
                this.items.forEach( (item, index) => {
                    if (item.extras.length === 0) {
                        this.items.splice(index, 1);
                    }
                })
            },
            mapCartStorage() {
                if(this.cartStorage.items.length > 0) {
                    this.cartData.date = this.cartStorage.courier.date
                    this.cartData.fulldate = this.cartStorage.courier.fulldate
                    this.cartData.time = this.cartStorage.courier.time
                    this.selectedDateIndex = this.cartStorage.selectedDateIndex
                    this.selectedTimes = this.cartStorage.selectedTimes
                    this.itemIndex = 0;

                    this.cartStorage.items.forEach((item, index) => {
                        // add item
                        this.cartItems.push(item);
                        // find item
                        const __item = _.find(this.items, i => i.id === item.id);
                        // find item index
                        const __index = _.findIndex(this.items, i => i.id === item.id);
                        // filter category by id
                        this.categories.some((category) => {
                            if(category.id === __item.category_id) {
                                category.items.some((product,index) => product.id === __item.id ? category.items.splice(index, 1) : null)
                            }
                        });
                        // Remove from array after add to the cart
                        this.items.splice(__index, 1);
                        // remove items not refer in date
                        if(this.items.length > 0) {
                            this.items.forEach((product, _index) => {
                                //this.cartItems.some((item) => item.id === product.id ? this.removeProductCategoryById(product.id) : '')

                                let filteredExtras = product.extras.some(e => e.date === this.cartData.date);
                                if(!filteredExtras) {
                                    this.items.splice(_index, 1)
                                }else{
                                    product.extras.forEach((extra, indexExtra) => {
                                        if(this.cartData.date === extra.date && !_.includes(extra.time, this.cartData.time)) {
                                            console.log('remover pois não existe horário');
                                            this.removeProductCategoryById(product.id);
                                        }

                                        if(this.cartData.date === extra.date && extra.quantity === 0) {
                                            console.log('remover pois não possui items', extra.date, extra.quantity, product.name);
                                            this.removeProductCategoryById(product.id);
                                        }

                                    })
                                }
                            })
                        }

                        //Change message alert for no items available
                        if (this.items.length === 0) {
                            this.noItemsToShow = true;
                            this.setNoItemsTextMessage();
                        }
                        this.isListFiltered = true;
                    });

                }
            },
            expandReadMore(index) {
                var cardapioDesc = $('.cardapio__desc').get(index);
                var cardapioReadMore = $('.cardapio__readmore').get(index);

                if( $(cardapioDesc).height() < 45 ) {
                    $(cardapioReadMore).css('display', 'none');
                }
                if( $(cardapioDesc).height() == 45 ) {
                    $(cardapioDesc).css('max-height', '100%');
                    $(cardapioReadMore).html('Fechar');
                } else {
                    this.closeReadMore(cardapioDesc, cardapioReadMore);
                }
            },
            closeReadMore(cardapioDesc, cardapioReadMore) {
                $(cardapioDesc).css('max-height', 45);
                $(cardapioReadMore).html('Ler mais...');
            },
            getCategories() {
                window.axios.get('/services/cardapio/categories')
                    .then(response => {
                        let categories = response.data.categories;

                        this.items.forEach((product) => {
                            let product_category = product.category_id;
                            let category = _.find(categories, cat => cat.id === product_category);
                            let _index = _.findIndex(this.categories, cat => cat.id === product_category);
                            if(_index < 0) {
                                this.categories.push({ id: category.id, name: category.name, items: [product] })
                            }else {
                                this.categories[_index].items.push(product)
                            }
                        });

                        this.mapCartStorage();

                    });

            },
            pushCategoriesBack(item) {

                let test = {
                category_id: 6,
                comments: null,
                created_at: "2017-10-26 21:06:59",
                desc: "Bolo caseiro feito com muito amor",
                extras: [],
                id: 2,
                name: "Bolo de Cenoura com Chocolate",
                photo: null,
                photo_full_url: null,
                price: "30.00",
                seller_id: 1,
                serve: "6",
                updated_at:"2017-10-26 21:06:59"
                }

                this.categories.some((category) => {
                    category.id === item.category_id ? category.items.push(test) : null
                })

                // Todo: rodar a função abaixo caso o carrinho esteja vazio. Mandar essa informação via EventBus junto com esse item
                this.isListFiltered = false;

            },
            refreshAt() {
                return refreshAt(0,1,0); //Will refresh the page at 00:01:00am
            },
            people(serve) {
                // console.log(serve)
                if(serve == "1") {
                    return "pessoa"
                } else if(serve >= "2") {
                    return "pessoas"
                }
            },
            removeProductCategoryById(id) {
                this.categories.some((category) => category.items.some((product, _index) => product.id === id ? category.items.splice(_index, 1) : null))
            }
        },
        watch:{
            'filterCategories.orderBy'(current) {
                let type = (current ? 'asc' : 'desc');
                this.categories = _.orderBy(this.categories, ['name'], [type])
            }
        },
        created() {
            this.setNow();
            this.refreshAt();
            //console.log("Date: " + moment().format("dddd, MMMM Do YYYY, h:mm:ss a"))
            // console.log(this.chef.times)
            this.$root.$on('bv::toggle::collapse', element => {
                let line = $(`#${element}`);
                let category = line.data('category')
                if(category === this.filterCategories.collapse.id) {
                    this.filterCategories.collapse.id = ''
                }else {
                    this.filterCategories.collapse.id = category
                }
            })

            // var self = this;
            // eventBus.$on('remove-item', (item) => self.pushCategoriesBack(item))
        },
        mounted() {
            this.getProducts();    
        },
        updated() {
            eventBus.$on('remove-item', (item) => window.location.reload())
        }
    }
</script>

<style scoped lang="scss">
    .cardapio {
        &__desc {
            max-height: 45px;
            overflow: hidden;
            text-align: justify;
            @media screen and (min-width: 768px) {
                max-width: 90%;
            }
        }
        &__readmore {
            font-size: 14px;
            text-decoration: underline;
            color: #a5adb9;
            cursor: pointer;
        }
    }

    .fade-enter-active, .fade-leave-active {
      transition: opacity .5s
    }
    .fade-enter, .fade-leave-to  {
      opacity: 0
    }


    /* Enter and leave animations can use different */
    /* durations and timing functions.              */
    .slide-fade-enter-active {
        transition: all .3s ease;
    }
    .slide-fade-leave-active {
        transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active for <2.1.8 */ {
        transform: translateY(20px);
        opacity: 0;
    }
    .disabled {
        pointer-events: none;
        color: #d4d4d4;
    }

    .component-fade-enter-active, .component-fade-leave-active {
        transition: opacity .5s ease;
    }
    .component-fade-enter, .component-fade-leave-to {
        opacity: 0;
    }
</style>
