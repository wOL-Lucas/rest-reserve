export class Address {
	constructor (
		public id = 0,
		public city = '',
		public uf = '',
		public neighborhood = '',
		public street = '',
		public number = '',
		public zipCode = '',
		public complement = '',
    public country = 'Brasil'
	) {}

	public toString (): string {
		return `${this.city}, ${this.uf}, ${this.neighborhood}, ${this.street}, ${this.zipCode}`
	}

	static fromJson (json: any): Address {
		return new Address(
			json.id,
			json.city,
			json.uf,
			json.neighborhood,
			json.street,
			json.number,
			json.zipCode,
			json.complement,
      json.country
		)
	}

	public toJson (): any {
		return {
			id: this.id,
			city: this.city,
			state: this.uf,
			neighborhood: this.neighborhood,
			street: this.street,
			number: this.number,
			zip_code: this.zipCode,
			complement: this.complement,
      country: this.country
		}
	}

	public isValid (): boolean {
		return this.city !== '' && this.uf !== '' && this.neighborhood !== '' && this.street !== '' && this.number !== '' && this.zipCode !== ''
	}
}
