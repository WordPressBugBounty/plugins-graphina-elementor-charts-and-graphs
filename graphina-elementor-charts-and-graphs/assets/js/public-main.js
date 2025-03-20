import $ from 'jquery';
import GraphinaPublic from './graphina-public';
$(function () {

    
    const GraphinaPublicMain = {
        'GraphinaPublic' : new GraphinaPublic(),
    };
    
    window['GraphinaPublicMain'] = GraphinaPublicMain;

})