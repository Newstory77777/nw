//Really don't like this realization
//There is no interfaces. And strategies are just functions, not objects in a classical sense

function addStrategy(a, b) {
    return a + b;
}

function multStrategy(a, b) {
    return a * b;
}

function divStrategy(a, b) {
    return a / b;
}

function subStrategy(a, b) {
    return a - b;
}

class CalcContext {
    constructor(a, b, strategy) {
        this.a = a;
        this.b = b;
        this.strategy = strategy;
    }

    count() {
        return this.strategy(a, b);
    }

    setAb(a, b) {
        this.a = a;
        this.b = b;
    }

    setStrategy(strategy) {
        this.strategy = strategy;
    }
}

let a = 10;
let b = 10;
let calc = new CalcContext(a, b, addStrategy);
console.log(a + '+' + b + '=' + calc.count());
calc.setStrategy(multStrategy);
console.log(a + '*' + b + '=' + calc.count());