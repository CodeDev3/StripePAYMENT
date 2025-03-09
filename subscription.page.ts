import { Component, OnInit } from '@angular/core';
import { ApiService } from '../services/api.service';
import { InAppBrowser } from '@awesome-cordova-plugins/in-app-browser';

@Component({
  selector: 'app-subscription',
  templateUrl: './subscription.page.html',
  styleUrls: ['./subscription.page.scss'],
  standalone: false,
})
export class SubscriptionPage implements OnInit {
  membershipPlans: any[] = [];
  constructor(private apiServices: ApiService) {}

  ngOnInit() {}

  ionViewWillEnter() {
    this.apiServices.get('pmpro/v1/membership_levels', '').subscribe({
      next: (res: any) => {
        console.log(res);
        this.membershipPlans = Object.values(res);
      },
      error: (err: any) => {
        console.log(err);
      },
    });
  }

  buySubscription(id: any) {
    let data = {
      membership_level_id: id,
    };
    console.log(data);
    this.apiServices.post('pmpro/v1/create-stripe-session', data).subscribe({
      next: (res: any) => {
        console.log(res);
      },
      error: (err: any) => {
        console.log(err);
      },
    });

    // this.apiServices.post('pmpro/v1/create-stripe-session', data).subscribe(
    //   (res: any) => {
    //     if (res.success && res.data.checkout_url) {
    //       const browser = this.iab.create(res.data.checkout_url, '_blank', {
    //         location: 'no',
    //         toolbar: 'yes',
    //         zoom: 'no',
    //       });

    //       browser.on('loadstop').subscribe((event) => {
    //         if (event.url.includes('payment-success')) {
    //           browser.close(); // Close browser on success
    //           alert('Payment Successful!');
    //         } else if (event.url.includes('payment-cancel')) {
    //           browser.close();
    //           alert('Payment Cancelled.');
    //         }
    //       });
    //     }
    //   },
    //   (error) => {
    //     console.error('Error:', error);
    //   }
    // );
  }
}
