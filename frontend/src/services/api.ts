
import axios, { type AxiosInstance, type AxiosResponse } from 'axios';

export interface ResponseService<T = any> {
  success: boolean;
  data: T;
  message: string | null;
}


const api: AxiosInstance = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
  withCredentials: false, 
});


const handleResponse = async <T = any>(request: Promise<AxiosResponse<ResponseService<T>>>): Promise<T> => {
  const response = await request;
  return response.data.data;
};


export const getData = <T = any>(url: string) => handleResponse<T>(api.get(url));
export const postData = <T = any>(url: string, payload?: any) => handleResponse<T>(api.post(url, payload));
export const putData = <T = any>(url: string, payload?: any) => handleResponse<T>(api.put(url, payload));
export const deleteData = <T = any>(url: string) => handleResponse<T>(api.delete(url));


export default api;
