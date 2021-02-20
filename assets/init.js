export default {
    init: () => {
        if (document.querySelector('.collection')) {
            $('.collection').collection({
                'add': '<a href="#" class="btn btn-primary"><i class="fas fa-plus"></i></a>'
            });
        }
    }
}