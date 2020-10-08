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

    getQuestionslug() {
        return this._data.slug;
    }

    getQuestionCategory() {
        return this._data.category;
    }

    getQuestionUser() {
        return this._data.user;
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
