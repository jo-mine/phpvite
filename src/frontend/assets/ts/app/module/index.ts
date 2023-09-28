import { createApp } from '@ts/base/CommonVue'
import { defineComponent } from 'vue'

const component = defineComponent({
    data () {
        return {
            text: 'hello world'
        }
    }
})
createApp(component).mount('#app')
