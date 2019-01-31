const Vue = require('vue');
const axios = require('axios');
const DatePicker = require('vue!./components/vendor/date.vue');

const currentPage = document.getElementsByClassName('currentPage');
let dataPage = currentPage[0].dataset.page;

if(dataPage == 'main') {

    const carItem = require('vue!./components/client/carItem.vue');

    new Vue({
        el: '#main',
        data: {
            cars:[],
            before:'',
            after:'',
            date:{
                begin:'',
                end:'',
            },
            time:{
                begin:'',
                end:'',
            },
            search:'',
        },
        components: {
            DatePicker: DatePicker,
            carItem:carItem,
        },
        methods: {
            getCars:function(){
                axios.get('/getCars').then(response => {
                    this.cars = response.data;
                })
            },
            checkDate:function(rents){
                if(this.date.begin == "" || this.date.end == ""){return true;}
                if(this.time.begin == "" || this.time.end == ""){return true;}

                let arrBeginDates = this.date.begin.split('.').reverse();
                let arrBeginTimes = this.time.begin.split(':');
                let beginUnix = new Date(arrBeginDates[0],parseInt(arrBeginDates[1] - 1),arrBeginDates[2],arrBeginTimes[0],arrBeginTimes[1]).getTime();

                let arrEndDates = this.date.end.split('.').reverse();
                let arrEndTimes = this.time.end.split(':');
                let endUnix = new Date(arrEndDates[0],parseInt(arrEndDates[1] - 1),arrEndDates[2],arrEndTimes[0],arrEndTimes[1]).getTime();

                if(!this.checkRents(beginUnix / 1000 ,endUnix / 1000,rents)){return false;}

                return true;
            },
            checkRents:function(beginUnix,endUnix,rents){
                if(rents == void(0)){return true;}
                console.log(rents);
                if(rents.length < 1){return true;}
                for(let i = 0; i < rents.length; i++){
                        if((Math.min(beginUnix, endUnix) <
                            Math.max(rents[i].beginUnix, rents[i].endUnix))
                       && ((Math.min(rents[i].beginUnix, rents[i].endUnix) <
                            Math.max(beginUnix, endUnix)))){
                            return false;
                        }

                }
                return true;
            },
            checkInput:function(item){
                if(item == void(0)){return false;}
                if(this.search == ''){return true;}
                if(~item.title.toUpperCase().indexOf(this.search.toUpperCase())){return true}
                return false;
            }
        },
        filters:{

        },
        created(){
            this.getCars();
        },
        updated(){
            this.checkDate();
            this.checkInput();
        }
    });

}else if(dataPage == 'manager') {

    const carItem = require('vue!./components/manager/carItem.vue');
    const addClient = require('vue!./components/manager/addClient.vue');
    const addCar = require('vue!./components/manager/addCar.vue');
    const carModal = require('vue!./components/manager/forms/carModal.vue');
    const rentModal = require('vue!./components/manager/forms/rentModal.vue');
    const rentTable = require('vue!./components/manager/rentTable.vue');

    new Vue({
        delimiters: ['${', '}'],
        el: "#manager",
        data: {
            cars: [],
            chooseCar: {},
            chooseRent: {},
            noactive: false,
        },
        components: {
            carItem: carItem,
            addClient: addClient,
            addCar: addCar,
            carModal: carModal,
            rentModal: rentModal,
            datePicker:DatePicker,
            rentTable:rentTable
        },
        methods: {
            getCar: function () {
                let param = $.param({data: {c: 'CarController', m: 'getAllCar'}});
                axios.post('/api', param, {headers: {'Content-type': 'application/x-www-form-urlencoded',}})
                    .then(response => {
                        this.cars = response.data;
                    });
            },
            checkActive: function (item) {
                if (this.noactive) return true;
                if (item.active) {
                    return true;
                } else {
                    return false;
                }
            },
            reCallCar: function () {
                this.getCar();
            },
            getCarModal: function (data) {
                this.chooseCar = data.description;
            },
            getRentModal:function(data){
                this.chooseRent = data.description;
            }
        },
        created() {
            this.getCar();
        },
        mounted() {

        }
    });
}