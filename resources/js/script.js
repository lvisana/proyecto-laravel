let url = 'http://proyecto-laravel.test/'

window.addEventListener('DOMContentLoaded', function() {
    if (document.querySelectorAll('.like-btn')) {

        const saveLike = (id) =>{
            let xhttp = new XMLHttpRequest;
            let url = url+'/like/'+id

            xhttp.open('GET', url, true);
        }

        let id

        document.querySelectorAll('.like-btn').forEach(el => {
            id = el.id
            el.addEventListener('click', function() {
                if (el.classList.contains('btn-liked')) {
                    el.setAttribute('src', url+'img/light-heart.png')
                    el.classList.remove('btn-liked')
                    saveLike(id)
                } else {
                    el.setAttribute('src', url+'img/red-heart.png')
                    el.classList.add('btn-liked')
                    saveLike(id)
                }
            })
        })

    }

})
