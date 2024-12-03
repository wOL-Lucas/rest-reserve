const BASE_USERS_URL = process.env.BASE_USERS_URL
const BASE_RESTAURANT_URL = process.env.BASE_RESTAURANT_URL
const BASE_RESERVE_URL = process.env.BASE_RESERVE_URL

export default class ApiRoutes {
    // Auth
    static login = `${BASE_USERS_URL}/login`

    // Users
    static users = `${BASE_USERS_URL}/users`

    // Restaurants
    static restaurants = `${BASE_RESTAURANT_URL}/restaurants`

    // Reserves
    static reserves = `${BASE_RESERVE_URL}/reserves`
}
