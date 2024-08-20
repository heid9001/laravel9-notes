import Alpine from "alpinejs";

/**
 * url = localhost/.../0 => localhost/.../id
 *
 * @param url
 * @param id
 * @returns {string}
 */
function withParams(url = '', id) {
    return url.slice(0, -1) + id;
}

/**
 * Компонент заметок, содержит состояние, мутаторы и ajax вызовы
 */
document.addEventListener('alpine:init', () => {
    Alpine.data('Notes', (args) => ({
        // состояние
        notes: [],
        errors: [],
        links: [],
        page: 0,
        title: '',
        content: '',
        id: 0,
        // мутаторы
        all() {
            axios.get(args.list)
                .then((r)=>{
                    this.notes = r.data.data;
                    let links = r.data.links;
                    links.pop(); links.shift();
                    this.links = r.data.links;
                });
        },
        navigate(page) {
            this.reset();
            this.resetErrors();
            if (! isNaN(page)) {
                axios.get('notes/paging', {
                    params: {
                        page: page
                    }
                }).then((r) => {
                    this.notes = r.data.data;
                    r.data.links.pop(); r.data.links.shift();
                    this.links = r.data.links;

                    this.page = page;
                });
            }
        },
        create() {
            this.resetErrors();
            axios.post(args.create, {
                title:   this.title,
                content: this.content
            }).then((r) => {
                this.reset();
                this.resetErrors();
                this.$dispatch('close');
                this.navigate(this.page);
            }).catch((err) => {
                this.handleErrors(err.response.data.errors);
            });
        },
        remove() {
            axios.delete(withParams(args.delete, this.id))
                .then((r) => {
                    let idx = this.notes.findIndex((note) => note.id === this.id);
                    this.notes.splice(idx, 1);
                    this.reset();
                    this.navigate(this.page);
                });
        },
        update() {
            this.resetErrors();
            axios.patch(withParams(args.update, this.id), {
                id: this.id,
                title: this.title,
                content: this.content
            }).then((r)=>{
                let idx = this.notes.findIndex((note) => note.id === this.id);
                if (idx !== -1) {
                    this.notes.splice(idx, 1, {
                        title: r.data.title,
                        content: r.data.content,
                        id: r.data.id
                    });
                }
                this.resetErrors();
                this.reset();
                this.$dispatch('close');
                this.navigate(this.page);
            }).catch((err) => {
                this.handleErrors(err.response.data.errors);
            });
        },
        // выбор объекта из списка
        choose(id) {
            this.resetErrors();
            this.reset();
            let note = this.notes.filter((note) => note.id === id)[0];
            this.title = note.title;
            this.content = note.content;
            this.id = note.id;
        },
        // сброс выбора
        reset() {
            this.title = this.content = '';
            this.id = 0;
        },
        resetErrors() {
            this.errors.splice(0, this.errors.length);
        },
        handleErrors(errors) {
            for (let error in errors) {
                this.errors.push(errors[error][0]);
            }
        }
    }));
});
