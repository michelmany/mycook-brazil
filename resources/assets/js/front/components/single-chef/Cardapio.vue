<template>
    <section class="cardapio">

        <vue-loading v-show="loading" type="bubbles" color="#F95700" :size="{ width: '50px', height: '50px' }" key="1"></vue-loading>

        <transition-group name="component-fade" mode="out-in">
            <div class="cardapio__item" v-for="(item, index) in items" key="itemKey" v-if="item.extras.length > 0">
                <div class="row px-3">
                    <div class="col-md-3 col-lg-5">
                        <div class="cardapio__image mb-3" style="background-image: url('/assets/img/hero-02.jpg')"></div>
                    </div>
                    <div class="col-md-9 col-lg-7">
                        <div>
                            <h5 class="cardapio__title text-uppercase">{{ item.name }}</h5>
                            <div class="cardapio__desc">{{ item.desc }}</div>
                            <div><span class="cardapio__serve badge badge-primary">Serve {{ item.serve }}</span></div>
                            <!-- To do: Pegar os dias que tem times setados e mostrar no span abaixo -->
                            <div class="cardapio__desc mt-3">Disponível nos dias: {{ dateRangeBadge(item) }}</div>
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
                                    @click="selectDate(weekDay, dayIndex, index)">{{ weekDay.date }}</li>
                            </div>
                        </transition>

                    </div>
                </div>

                <sweet-modal ref="modalTime">
                    
                    <!-- To do: adicionar component de trocar endereço direto no modal -->
                    <div class="card mb-3">
                        <div class="card-block">
                            <h6 class="card-title text-uppercase">Endereço</h6>
                            <p class="card-text"><small>Estrada Francisco da Cruz Nunes 1234, Piratininga - Niterói/RJ</small></p>
                            <a href="#" class="btn btn-outline-secondary btn-sm">Trocar endereço</a>
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
                            <!-- <i class="fa fa-arrow-circle-o-right"></i> -->
                            </h4>
                        </div>
                    </div>
                    
                    <button slot="button" class="btn btn-submit-orange" 
                    v-bind:disabled="cartData.time.length == 0" 
                    v-bind:class="{ disabled: cartData.time.length == 0 }" 
                    @click="continueToCart(item, index)">Continuar</button>
                </sweet-modal>

            </div>
            <div v-show="items.length == 0" key="message">
                <div class="alert alert-warning" role="alert">
                    {{noItemTextMessage}}
                </div>
            </div>
        </transition-group>

    </section>
</template>

<script>
    import { eventBus } from '../../app';
    import vueLoading from 'vue-loading-template'
    import Moment from 'moment';
    import { extendMoment } from 'moment-range';
    const moment = extendMoment(Moment);
    import { HttpService } from '../../services/httpService';
    let httpService = new HttpService();

    import Ls from '../../../painel/services/ls'

    export default {
        data() {
            return {
                btnLabel: "Agendar entrega",
                noItemTextMessage: "Nenhum produto cadastrado no cardápio!",
                loading: false,
                showDays: false,
                isListFiltered: false,
                selectedTimes: [],
                itemIndex: '',
                now: '',
                items: {},
                selectedDateIndex: '',
                cartData: {
                    time: '',
                    date: '',
                },
                cartItems: []
            }
        },
        props: ["chefId"],
        watch: {

        },
        methods: {
            getProducts() {
                this.loading = true;

                setTimeout(() => {
                    axios.get('/get-products/' + this.chefId)
                    .then((res) => {
                        this.loading = false
                        this.items = res.data
                        // console.log(res.data)

                        this.orderingWeekDays()
                        this.getRangeTime()
                    })
                }, 500);

            },
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
            selectDate(weekday, dayIndex, index) {
                this.setNow()
                this.selectedTimes = weekday.time;
                this.cartData.date = weekday.date;
                this.cartData.fulldate = weekday.fulldate;

                this.selectedDateIndex = dayIndex;

                // Fitler the time for today
                if(weekday.date == 'Hoje') {
                    this.filterTodayTime(weekday.time)
                }

                // Open Modal
                this.$refs.modalTime[index].open()

                // Clear cart when user selects new date or time
                this.clearCart()
            },
            continueToCart(item, index) {
                this.$refs.modalTime[index].close()
                this.addItem(item, index);
            },
            addItem(item, index) {

                //add to the cart
                this.cartItems.push({
                    id: item.id,
                    name: item.name,
                    desc: item.desc,
                    price: item.price,
                    availableQty: item.extras[this.selectedDateIndex].quantity,
                    qty: 1
                });

                eventBus.$emit('cartItems', this.cartItems, this.cartData);

                // Remove from array after add to the cart
                this.items.splice(index, 1);

                //Change message alert for no items available
                if (this.items.length == 0) {
                    this.setNoItemsTextMessage();
                }

                //shows only the products available on this day selected
                if (this.isListFiltered == false) {
                    this.FilterByDaySelected(item, index);
                }

            },
            FilterByDaySelected(item, index) {

                this.isListFiltered = true;
                this.showDays = false;

                console.log("time selected: " + this.cartData.time)
                console.log("Outside loop: " + item.name + " - index: " + index)

                this.items.forEach( (item, index) => {

                    console.log("Inside loop: " + item.name + " - index: " + index)

                    item.extras.forEach( (extra) => {
         
                        if (extra.date == this.cartData.date ) {
                            if (!_.includes(extra.time, this.cartData.time) || extra.quantity == 0 ) {
                                console.log("Date:" + extra.date)
                                console.log("removing item: " + item.name + " index: " + index)
                                this.items = _.without(this.items, item);
                            }
                        } 

                        //Todo: formatar com moment.js a data do Carrinho e tambem da mensagem de alert.

                    })
                });


                //Change message alert for no items available
                if (this.items.length == 0) {
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
                        const ArrayTimes = Array.from(TimeRange.by('hours'))
                        //To do: Colocar o range de 30 em 30 minutos ao invés de hora em hora
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
                this.selectedTimes = []
                times.forEach((time, index) =>  {
                    if (moment(time).unix() > this.now) {
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
                console.log(todayTime);
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
            }

        },
        mounted() {
            this.getProducts()
        },
        created() {
            this.setNow()

            console.log("Date: " + moment().format("dddd, MMMM Do YYYY, h:mm:ss a"))
            // console.log(this.chef.times)

            eventBus.$on('remove-item', payload => {
                console.log(payload)
                if(payload.qty === 0) {
                    this.cartData = {};
                    this.cartItems.splice(index, 1);
                }
            })
        }

    }
</script>

<style scoped>
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