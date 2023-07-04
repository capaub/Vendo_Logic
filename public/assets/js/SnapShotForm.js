    export class SnapShotForm {
        constructor(form) {
            this.form = form;
            this.snapshot = {};
            this.shot();
        }

        shot() {
            this.snapshot = {};
            let elements = this.form.elements;
            for (let i = 0; i < elements.length; i++) {
                const element = elements[i];
                if (element.tagName === 'INPUT') {
                    if (element.type === 'checkbox' || element.type === 'radio') {
                        this.snapshot[element.name] = element.checked;
                    } else {
                        this.snapshot[element.name] = element.value;
                    }
                } else if (element.tagName === 'SELECT') {
                    this.snapshot[element.name] = element.options[element.selectedIndex].value;
                } else if (element.tagName === 'TEXTAREA') {
                    this.snapshot[element.name] = element.value;
                }
            }
            return this.snapshot;
        }

        restoreShot() {
            const elements = this.form.elements;
            for (let i = 0; i < elements.length; i++) {
                const element = elements[i];
                if (this.snapshot[element.name] !== undefined) {
                    if (element.tagName === 'INPUT') {
                        if (element.type === 'checkbox' || element.type === 'radio') {
                            element.checked = this.snapshot[element.name];
                        } else {
                            element.value = this.snapshot[element.name];
                        }
                    } else if (element.tagName === 'SELECT') {
                        const options = element.options;
                        for (let j = 0; j < options.length; j++) {
                            if (options[j].value === this.snapshot[element.name]) {
                                element.selectedIndex = j;
                                break;
                            }
                        }
                    } else if (element.tagName === 'TEXTAREA') {
                        element.value = this.snapshot[element.name];
                    }
                }
            }
        }
    }


