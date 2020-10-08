class Question {

    _data;


    loadData(data) {
        this._data = data;
        return this;
    }
    
    getQuestionId() {
        return this._data.id;
    }

    getQuestionTitle() {
        return this._data.title;
    }

    getQuestionContent() {
        return this._data.content;
    }

    getQuestionContent() {
        return this._data.slug;
    }

    // foo() {
    //     /** ici du code */
    //     console.log('called foo');
    //     return this;
    // }

    // bar() {
    //     /** ici du code */
    //     console.log('called bar');
    //     return this;
    // }
}
