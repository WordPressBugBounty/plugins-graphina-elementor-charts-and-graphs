import Graphina_Admin_Dashboard from './Graphina_Admin_Dashboard'
jQuery(function () {
    const GraphinaModule = {
        'Graphina_Admin_Dashboard' : new Graphina_Admin_Dashboard(),
    }
    window['GraphinaModule'] = GraphinaModule
})