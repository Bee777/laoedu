const EMPTY_STATE = 'emptyState', plugin = {};

const isArray = (obj) => {
    return Object.prototype.toString.call(obj) === '[object Array]';
};
const isObject = (obj) => {
    return Object.prototype.toString.call(obj) === '[object Object]';
};

plugin.install = (Vue, options = {}) => {
    if (!Vue._installedPlugins.find(plugin => plugin.Store)) {
        throw new Error("VuexUndoRedo plugin must be installed after the Vuex plugin.")
    }
    Vue.mixin({
        data() {
            return {
                done: [],
                undone: [],
                newMutation: true,
                watchOnly: options.watchOnly || false,
                watchMutations: options.watchMutations || [],
                ignoreMutations: options.ignoreMutations || []
            };
        },
        created() {
            if (this.$store) {
                this.$store.subscribe(mutation => {
                    if (this.watchOnly) {
                        if (mutation.type !== EMPTY_STATE && this.watchMutations.indexOf(mutation.type) !== -1) {
                            this.done.push(mutation);
                        }
                    } else if (mutation.type !== EMPTY_STATE && this.ignoreMutations.indexOf(mutation.type) === -1) {
                        this.done.push(mutation);
                    }
                    if (this.newMutation) {
                        this.undone = [];
                    }
                });
            }
        },
        computed: {
            canRedo() {
                return this.undone.length;
            },
            canUndo() {
                return this.done.length;
            }
        },
        methods: {
            redo() {
                let commit = this.undone.pop();
                this.newMutation = false;
                if (isObject(commit.payload)) {
                    this.$store.commit(`${commit.type}`, Object.assign({}, commit.payload));
                } else if (isArray(commit.payload)) {
                    this.$store.commit(`${commit.type}`, Object.assign([], commit.payload));
                } else {
                    this.$store.commit(`${commit.type}`, commit.payload);
                }
                this.newMutation = true;
                this.$emit('onRedo', {done: this.done, undone: this.undone})
            },
            undo() {
                this.undone.push(this.done.pop());
                this.newMutation = false;
                this.$store.commit(EMPTY_STATE);
                this.done.forEach(mutation => {
                    if (isObject(mutation.payload)) {
                        this.$store.commit(`${mutation.type}`, Object.assign({}, mutation.payload));
                    } else if (isArray(mutation.payload)) {
                        this.$store.commit(`${mutation.type}`, Object.assign([], mutation.payload));
                    } else {
                        this.$store.commit(`${mutation.type}`, mutation.payload);
                    }
                    this.done.pop();
                });
                this.newMutation = true;
                this.$emit('onUndo', {done: this.done, undone: this.undone});
            }
        }
    });
};
export default plugin;
