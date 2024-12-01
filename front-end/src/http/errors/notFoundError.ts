export class NotFoundError extends Error {
	constructor (message = 'Não encontrado') {
		super(message)
		this.name = 'NotFoundError'

		Object.setPrototypeOf(this, NotFoundError.prototype)
	}
}
