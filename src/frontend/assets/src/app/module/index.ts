const component = Vue.defineComponent({
    data() {
        return {
            text: 'hello world',
        }
    }
})
Vue.createApp(component).mount('#app')
