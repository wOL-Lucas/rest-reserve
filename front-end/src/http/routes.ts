const BASE_URL = process.env.REACT_APP_BASE_URL

export default class ApiRoutes {
    static signup = `${BASE_URL}/signup`
    static signin = `${BASE_URL}/signin`
    static forgotPassword = `${BASE_URL}/forgot`
    static resetPassword = `${BASE_URL}/reset-password`
    static changePassword = `${BASE_URL}/change-password`
    static refreshToken = `${BASE_URL}/refresh-token`

    static user = `${BASE_URL}/user`
    static me = `${BASE_URL}/user/me`
    static mePhoto = `${BASE_URL}/user/me/photo`

    static apiKey = `${BASE_URL}/user/api-key`

    static customer = `${BASE_URL}/customer`

    static category = `${BASE_URL}/category`

    static releaseType = `${BASE_URL}/release-type`

    static constructionCompany = `${BASE_URL}/construction-company`

    static lead = `${BASE_URL}/lead`
    static leadCreateUser = `${BASE_URL}/lead/{id}/create-user`

    static enterprise = `${BASE_URL}/enterprise`
    static enterpriseSearch = `${BASE_URL}/enterprise/search`
    static enterpriseStatusUpdate = `${BASE_URL}/enterprise/{id}/update-status`
    static enterpriseConstructionStep = `${BASE_URL}/enterprise/{id}/construction-step`

    static simulation = `${BASE_URL}/simulation`
    static sendSimulation = `${BASE_URL}/simulation/{id}/send`
    static updateSimulationStatus = `${BASE_URL}/simulation/{id}/status`
    static simulationDocument = `${BASE_URL}/simulation/{id}/document`
    static simulationSumary = `${BASE_URL}/simulation/{id}/sumarry`
    static simulationPreApprovedSales = `${BASE_URL}/simulation/{id}/pre-approved-sales`
    static simulationProposals = `${BASE_URL}/simulation/{id}/proposals`

    static dataUser = `${BASE_URL}/data-user`

    static tenant = `${BASE_URL}/tenant`
}