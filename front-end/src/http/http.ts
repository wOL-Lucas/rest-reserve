import HttpRequest from './httpRequest'

export default interface Http {
    get<T>(httpRequest: HttpRequest, retried?: number): Promise<T>
    post<T>(httpRequest: HttpRequest, retried?: number): Promise<T>
    put<T>(httpRequest: HttpRequest, retried?: number): Promise<T>
    delete(httpRequest: HttpRequest, retried?: number): Promise<void>
}
