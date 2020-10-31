class ToggleLike
{

    _likeRepository;

    constructor(likeRepository) {
        this._likeRepository = likeRepository;
    }

    initialize() {
        console.log('ToggleLike initialized');
        let likeForms = document.querySelectorAll('.like-form');
        for (let likeForm of likeForms) {
            likeForm.addEventListener('submit', (event) => {this.handleLikeFormSubmit(event)});
        }
    }

    handleLikeFormSubmit(event) {
        event.preventDefault();
        const answerId = event.target.dataset.answerId;
        this._likeRepository.toggleLike(answerId).then((response) => {
            // console.log(response);
            const likeStatus = response['likeStatus'];
            console.log(likeStatus);
            

        })
    }

}