import env from "../env.json";

export async function rate(ratesOf = "EUR") {
    const endpoint = `https://api.freecurrencyapi.com/v1/latest?apikey=${env.exchangerKey}&currencies=${ratesOf}&base_currency=USD`;

    if (localStorage.getItem(ratesOf)) {
        return JSON.parse(localStorage.getItem(ratesOf));
    } else {
        try {
            const response = await fetch(endpoint);
            const data = await response.json();
            const result = data.data[ratesOf];

            // Cache the result in localStorage for 60 seconds
            localStorage.setItem(ratesOf, JSON.stringify(result));
            setTimeout(() => localStorage.removeItem(ratesOf), 60000);

            return result;
        } catch (error) {
            console.error("Error fetching the currency data:", error);
            throw error;
        }
    }
}

