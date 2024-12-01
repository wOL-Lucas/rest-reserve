export class HttpError extends Error {
	constructor (
        public status = 500,
        public friendlyTitle = 'Erro interno no servidor',
        public friendlyMessage = 'Ocorreu um erro inesperado, tente novamente mais tarde.',
    ) {
		super(friendlyMessage)
		this.name = 'HttpError'

		Object.setPrototypeOf(this, HttpError.prototype)
	}
}
