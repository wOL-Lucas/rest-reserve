export default class HttpRequest {
    constructor(
        public path: string,
        public body?: any,
        public params?: Record<string, any>,
        public basicAuth?: { username: string; password: string },
        public headers?: any,
        public retries: number = 3,
    ) {}
}