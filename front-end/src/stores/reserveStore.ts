import { defineStore } from 'pinia';
import { AxiosHttp } from 'src/http/axios';
import HttpRequest from 'src/http/httpRequest';
import ApiRoutes from 'src/http/routes';
import { Reserve } from 'src/models/reserve';
import { NotifyError } from 'src/utils/utils';

export const useReserveStore = defineStore('reserve', {
  state: () => ({
    reserves: [] as Reserve[],
    http: new AxiosHttp()
  }),
  actions: {
    async fetchReserves() {
      const request = new HttpRequest(ApiRoutes.reserves);
      await this.http.get<Reserve[]>(request)
        .then((response: Reserve[]) => {
          this.reserves = response;
        })
        .catch((error) => {
          NotifyError.error(error.message);
        });
    }
  },
});
