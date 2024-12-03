export class Reserve {
	constructor (
		public id = 0,
    public createdBy = '',
    public restaurantId = '',
    public reservationDate = '',
    public reservationTime = '',
    public numberOfPeople = 0,
    public status = '',
    public observation = '',
    public createdAt = new Date(),
	) {}

	static fromJson (json: any): Reserve {
		return new Reserve(
      json.id,
      json.user_id,
      json.restaurant_id,
      json.reservation_date,
      json.reservation_time,
      json.number_of_people,
      json.status,
      json.observation,
      new Date(json.created_at)
		)
	}

	public toJson (): any {
		return {
      id: this.id,
      user_id: this.createdBy,
      restaurant_id: this.restaurantId,
      reservation_date: this.reservationDate,
      reservation_time: this.reservationTime,
      number_of_people: this.numberOfPeople,
      status: this.status,
      observation: this.observation,
      created_at: this.createdAt
		}
	}
}
