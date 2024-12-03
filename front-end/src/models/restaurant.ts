import { Address } from './address'

export class Restaurant {
	constructor (
		public id = 0,
    public createdBy = 0,
    public name = '',
    public address = new Address(),

	) {}

	static fromJson (json: any): Restaurant {
		return new Restaurant(
      json.id,
      json.createdBy,
      json.name,
      Address.fromJson(json.address)
		)
	}

	public toJson (): any {
		return {
      id: this.id,
      user_id: this.createdBy,
      name: this.name,
      address: this.address.toJson()
		}
	}
}
