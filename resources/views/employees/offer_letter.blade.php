<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Xeam Letter Head</title>
        <!--Bootstrap 4 link and Scripts starts here-->
        <link rel="stylesheet" href="{{asset('public/admin_assets/bower_components/bootstrap/dist/css/bootstrap4.min.css')}}">
        <script src="{{asset('public/admin_assets/bower_components/jquery/dist/jquery.min.js')}}"></script>
        <script src="{{asset('public/admin_assets/bower_components/bootstrap/dist/js/popper.min.js')}}"></script>
        <script src="{{asset('public/admin_assets/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <!--Bootstrap 4 link and Scripts ends here-->
       <style type="text/css">
          * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-size: 16px;
            /*line-height: 1.7px;*/
            color: #777;
        }

        .base-img {
            padding: 20px;
        }

        .image1 img {
            width: 110px;
        }
        .image2 img {
            width: 100px;
        }
        .image3 img, .image5 img, .image6 img, .image7 img {
            width: 60px;
        }
        .image4 img {
            width: 160px;
        }
        .main-content {
            background: url(img/bg1.png) no-repeat;
            background-position: 50% 80%;
        }
        .al-content {
            font-size: 1.25rem;
        }
        ul li {
          list-style-type: none;
        }
        .signature-box-content {
          width: 300px;
          position: relative;
          left: 60%;
        }
        </style>
    </head>
  <body>
      <!--Section starts here-->
      <section class="mx-2 mt-2 mb-5">
          <div class="container-fluid border">
              <div class="row justify-content-center align-items-center m-3">
                 <div class="base-img image7">
                     <img src="{{asset('public/admin_assets/static_assets/29990-2010.png')}}" alt="logo image 29990-2010">
                 </div>
                 <div class="base-img image1">
                     <img src="{{asset('public/admin_assets/static_assets/nsdc-logo.png')}}" alt="nsdc logo">
                 </div>
                 <div class="base-img image3">
                     <img src="{{asset('public/admin_assets/static_assets/9001-2015.png')}}" alt="logo image 9001-2015">
                 </div>
                 <div class="base-img image4">
                     <img src="{{asset('public/admin_assets/static_assets/xeam-logo.png')}}" alt="xeam logo">
                 </div>
                 <div class="base-img image2">
                     <img src="{{asset('public/admin_assets/static_assets/cmmi-logo.png')}}" alt="">
                 </div>
                 <div class="base-img image5">
                     <img src="{{asset('public/admin_assets/static_assets/14001-2015.png')}}" alt="logo image 14001-2015">
                 </div>
                 <div class="base-img image6">
                     <img src="{{asset('public/admin_assets/static_assets/20000-2011.png')}}" alt="logo image 20000-2011">
                 </div>
              </div>
              
              <div class="text-center mx-3">
                  <p><b>HR SOLUTIONS &nbsp;|&nbsp;  IT/ ITES &nbsp;|&nbsp; SKILL DEVELOPMENT &nbsp;|&nbsp; US STAFFING &nbsp;|&nbsp; KPO/ BPO &nbsp;|&nbsp; SURVEY</b></p>
              </div>
              
              
              <div class="main-content mx-5" style="min-height: 1000px;">
                <div class="row justify-content-between mx-5">
                  <span>To,</span>
                  <span><b>Date:</b> {{@$user->employee->joining_date}}</span>
                </div>
                <p class="mx-5">
                  <span class="d-block">Mr./Mrs. {{@$user->employee->fullname}}</span>
                  <span class="d-block">S/o Mr. {{@$user->employee->father_name}}</span>
                  <span class="d-block">House Number - {{@$user->employeeAddresses[1]->house_number}},</span>
                  <span class="d-block">Road/Street  - {{@$user->employeeAddresses[1]->road_street}},</span>
                  <span class="d-block">Locality/Area - {{@$user->employeeAddresses[1]->locality_area}},</span>
                  <span class="d-block">{{@$user->employeeAddresses[0]->city->name}} , {{@$user->employeeAddresses[0]->state->name}} - {{@$user->employeeAddresses[0]->pincode}}</span>
                </p>

                <div class="al-content mt-5 mx-5 mb-5 text-justify">
                  <h4 class="text-center mt-5">Appointment Letter</h4>
                  <p class="mt-5">Dear Mr./Mrs. <b>{{@$user->employee->fullname}}</b></p>
                  <p>We <b>(M/s XEAM Ventures Pvt. Ltd.)</b> are pleased to offer you appointment as <b>“{{@$user->roles[0]->name}}”</b> w.e.f. <b>{{@$user->employee->joining_date}}</b> in our organization. The terms and conditions of your appointment are detailed in this Appointment Letter and any subsequent change/ modification applicable to employees that come into effect from time to time shall form the part of this Appointment Letter as an addendum.</p>
               </div>
              </div>

              
              <div class="text-center">
                  <h3>XEAM Ventures Private Limited</h3>
                  <p>CIN: 072300PB2004PTC040188</p>
              </div>
              
              <div class="row mt-3">
                  <div class="col-md-5">
                      <h4>Registered Office</h4>
                      <span class="d-block"><b>India:</b> E-202, Phase 8B, Industrial Area, Mohali (Chandigarh).</span>
                      <span class="d-block"><b>USA:</b> 5716 Corsa AVE STE #110 Westlake Village, CA – 91362</span>
                      <span class="d-block"><b>Website:</b> www.xeamventures.com</span>
                      <span class="d-block">Board: 0172-4360000</span>
                      <span class="d-block"><b>Helpline:</b> HR Team: 9856836000</span>
                  </div>
                  <div class="col-md-7 text-right">
                      <h4>Branch Offices </h4>
                      <span class="d-block"><b>Chandigarh:</b> SCO 87-88, 2nd Floor, Sector 34A, Chandigarh </span>
                      <span class="d-block"><b>Delhi:</b> #4, 3rd Floor, 506 Aravali Appartments, Mahipalpur,New Delhi - 110037 </span>
                      <span class="d-block"><b>Luknow:</b> #95, 102, 1st Floor, Jeewan Plaza, Vipul Khand 2, Gomti Nagar.</span>
                      <span class="d-block"><b>Bhopal:</b> Plot 212 F-4 Hare Govind Complex, Zone -1, MP Nagar, Bhopal </span>
                      <span class="d-block"><b>Jaipur:</b> E-857, Near Amrapali Circle, Vaishali Nagar, Jaipur - 302021 </span>
                  </div>
              </div>
              <div class="row mb-4">
                  <div class="col-md-3 pr-0">
                      <span class="d-block">Service Delivery: 9856836001</span>
                      <span class="d-block">Business Development: 9856836002</span>
                  </div>
                  <div class="col-md-9 text-right pl-0">
                      <span class="d-block"><b>Kolkata:</b> Poddar Court, Gate No. 1, 5th Floor, Room No. 529-A 18, Rabindra Sarani, kolkata-70000</span>
                      <span class="d-block"><b>Bhuvneshwar:</b> Premises No. 206, 2nd Floor, Commercial Block, Plot No. 2171 (Sabak Mouza: West Badagada)</span>
                  </div>
              </div>
          </div>
      </section>
      <!--Section ends here-->
      <br>

      <section class="border mx-2 px-5 py-3">
          <ul>
            <li>
              <h5>1. EMPLOYMENT</h5>
              <ul>
                <li><b>1.1:</b> You are now appointed to the position of {{@$user->roles[0]->name}} shall be based at Mohali. You shall be deemed to be an employee of the Company and not workman as defined in the industrial Disputes Act, 1947.</li>
                <li><b>1.2:</b> Notwithstanding the date of execution of the letter of appointment, said employment is deemed to have come into effect on {{@$user->employee->joining_date}}. This Letter supersedes your all previous communications with the company.</li>
                <li><b>1.3:</b> Your employment shall be valid from the date of your joining your duties. There will be a probation period of 3 month. If you would like to leave during training/probation period, you have to intimate us by giving 1 month prior notice.</li>
                <li><b>1.4:</b> Your address as indicated in your application for appointment shall be deemed to be correct for sending any communication to you and every communication addressed to you at the given address shall be deemed to have been served upon you. In case there is any change in your residential address, you will intimate the same in writing to the Personnel Department/Manager within three days from the date of such change and get such change of address recorded.</li>
              </ul>
            </li>
            <br>
            <li>
              <h5>2. LEAVE</h5>
              <p>You will be entitled to take leave/s as per the leave policy of the company</p>
            </li>
            <br>
            <li>
              <h5>3. POWERS & DUTIES</h5>
              <ul>
                <li><b>3.1:</b> You shall perform and discharge the duties of obligation which may be assigned to you by the company from time to time, faithfully, diligently to the best of your ability, in the interests of the company and in a manner consistent with company’s policies. You shall be responsible for maintaining all the records pertaining to the work assigned to you.</li>
                <li><b>3.2:</b> You are responsible for performing the services well in office time. However if the services are delayed beyond office hours, no overtime would be paid.</li>
                <li><b>3.3:</b> Paid leave/s & Festive leave/s will be given as per company’s leave policy. However, one weekly rest will be allowed. All deductions like TDS etc will be as per law. No TA/DA will be paid and you are required to join at the place of posting at your own expenses.</li>
                <li><b>3.4:</b> You are required to wear the prescribed Uniform /ID Card and observe strict discipline.</li>
                <li>You have to declare that the qualifications and experience proofs submitted by you are genuine. You are also required to get the background verification done as per prescribed format by Company.</li>
              </ul>
            </li>
            <br>
            <li>
              <h5>4. REMUNERATION</h5>
              <ul>
                <li><b>4.1:</b> As an employee of the company you will receive remuneration as per Annexure D. This will be disbursed to you in accordance with the prevailing standard plans of the company’s information on which will be provided to you upon joining the company.</li>
                <li><b>4.2:</b> The remuneration paid to you has been taken into consideration on the basis of the status and responsibilities of the appointment and as such, you will not be entitled to any other payment by way of overtime and other allowance.</li>
              </ul>
            </li>
            <br>
            <li>
              <h5>5. CODE OF CONDUCT</h5>
              <ul>
                <li><b>5.1:</b> You shall, at all times, be required to carry out such duties and responsibilities as may be assigned to you by the Company and shall faithfully and diligently perform these in compliance with established policies and procedures, endeavoring to the best of your ability to protect and promote the interests of the company.</li>
                <li><b>5.2:</b> You shall not, except with the written permission of the company engage directly or indirectly any other Business, Assignments, Occupation or Activity, whether as a Principal Agent or otherwise, which will be detrimental, whether directly, or indirectly, to the Company’s interests.</li>
                <li><b>5.3:</b> You shall keep strictly confidential details of your salary and employment benefits within and outside the Company.</li>
                <li><b>5.4:</b> You shall not disclose or divulge any confidential information related to the Company’s business or its customers which may come to your knowledge or notice.</li>
                <li><b>5.5:</b> You are expected to carry out your duties in a professional, responsible and conscientious manner, and to be accountable for their official conduct and decisions. They have an obligation to carry out official decisions and adhere to policies to policies faithfully and impartially</li>
                <li><b>5.6:</b> You are not allowed to misuse the organization facilities for your personal use, except where the facilities are being provided for personal use by policy. Even while using the facility for official purpose, any employee should ensure reasonable usage and avoid misuse.</li>
                <li><b>5.7:</b> You are asked to treat your peers, colleagues, subordinates, seniors, management with respect, fairness, courtesy and equity.</li>
                <li><b>5.8:</b> You must ensure that your personal interests should at no point of time conflict with the duties, obligations and responsibilities towards Xeam Ventures Pvt. Ltd. The employees of Xeam Ventures Pvt. Ltd should be sensitive to the potential for conflicts of interest to arise between their personal interests and their organizational duties, obligations and responsibilities.</li>
                <li><b>5.9:</b> You should not engage in any act subversive of discipline in the course of your assignment/s to the property of Company or outside, and if you were at anytime found indulging in such act/s, the management reserve the right to initiate disciplinary action as is deemed fit, against you, up to the extent of termination of the employment.</li>
                <li><b>5.10</b>: If at any time it is observed by the company, that data/documents in any manner have been manipulated or tempered by you directly or indirectly or any of your action has resulted in financial loss to the company, the company may without any prejudice has the right to initiate criminal proceedings and may impose penalty on you.</li>
                <li class="mb-3"><b>5.11</b>: You shall not be entitled to any kind of medical allowance or any other allowance from the company. There would be no medical responsibility of the company in case of any mis happening, accident, and death during the tenure of the employment at the premises or place of working or at any other place. No compensation can be claimed.</li>
              </ul>
            </li>
          </ul>
        </section>

        <br>
        <section class="border mx-2 px-5 py-3">
          <ul>
            <li>
              <h5>6. TERMINATION OF EMPLOYMENT</h5>
              <ul>
                <li><b>6.1:</b> This employment shall remain in force until:-<br> 
                    <b>a)</b>  Determined in writing with consent of the Employer;<br>
                    <b>b)</b>  The employer/company becoming insolvent;<br>
                    <b>c)</b>  The employer being declared bankrupt or of insolvent mind;<br>
                    <b>d)</b>  The Employee in order to terminate his/her services must give in writing notice of termination as provided below;<br>
                    <p>Employee must give 60 days prior written notice of termination to the company, provided always that in the event of employee leaving the employment of the company for any reason whatsoever prior to 07-January-2022. He/she shall there upon liable to pay to the company the damages and by this signature appended to this letter consent to judgment there for being granted against him by the Court in India.</p>
                </li>
                <li><b>6.2:</b> Company reserves the right not to relieve you of your service in the event that all company document & property in your custody have not been properly handed over by you to an authorized representative.</li>
                <li><b>6.3:</b> Company can terminate your service by giving one month notice, which notice, may be given as of right & without ascribing any reason thereof.</li>
                <li><b>6.4:</b> During notice period, you will remain bound by all of the express and implied obligations arising out of your employment with the company, including the obligations of good faith. You will co-operate with the company, as reasonably requested by the company, to effect a transition of your responsibilities and ensure that the company is aware of all matters being handled by you. However, you may, at the Company option, be required to cease to render all or some of your duties, and/or to remain away from office premises and not work for anyone else, during all or part of notice period.
                </li>
              </ul>
            </li>
            <br>
            <li>
              <h5>7. TERMINATION FOR CAUSE</h5>
              <ul>
                <li>
                  <p>Your employment shall be liable to termination upon:</p>
                  <ul>
                    <li><b>(i)</b> Any material breach of the terms of this letter of offer or any representation made by you herein.</li>
                    <li><b>(ii)</b>  On any action or omission on your part which is in Conflict with the interests of the Company or found you guilty for dishonesty, willful to disobey the orders or breaking up the code of conduct.</li>
                    <li><b>(iii)</b> Further, In case of working or any situation like resignation from current company, you are not eligible for Interview participation or for employment purpose with any of our competitors in nearby location without the written consent from the Company.</li>
                    <li><b>(iv)</b>  In case you are found guilty of criminal, civil offences by any competent authority OR under any pre-contract verification initiated by the Company OR match any known regulatory/financial/ terrorist blacklists including OR you are identified to be engaged in any criminal activity during the term of this agreement or.</li>
                    <li><b>(v)</b> If the client or the Company do not require your services any more (reason not required).</li>
                    <li><b>(vi)</b>  If the leaves taken by you without written permission of the Company.</li>
                    <li><b>(vii)</b> Any other reason recognized in law for dismissal of Employees.</li>
                  </ul>
                </li>
                <li>In the above cases, the Company shall not be required to provide you with any notice prior to termination of your employment, and the Company shall not be obligated to make any further payments to you (other than any accrued and unpaid salary and expenses to the date of termination), or continue to provide any benefit (other than any benefit which may have accrued pursuant to any plan or as required by law, whichever is lower) to you.</li>
              </ul>
            </li>
            <br>
            <li>
              <h5>8. RELOCATION/ TRANSFER</h5>
              <p>You are liable to be transfer from one job to another, one shift to another, one department to another and also can be transferable to any other location as per Requirement of the company. Upon 
              Such Transfer your services shall be governed by the Rules, regulations, term and condition of service etc. that may be applicable to the place of transfer. Presently, you are posted at Mohali.
              </p>
            </li>
            <li>
              <h5>9. INDEMNIFY</h5>
              <p>You shall always be liable to indemnify to the Company even after leaving your services from the Company for any loss sustained by the Company due to any act, omission, misconduct, negligence or default in the course of discharging of your duties whilst in the service of the Company.
              </p>
            </li>
            <li>
              <h5>10. POST-EMPLOYMENT OBLIGATIONS</h5>
              <p>In case you leave the company for whatsoever reason, you do hereby agree that you would not join any person, association of persons, firm or company directly or indirectly in competition with the business of the company for a period of two year from the date of relieving from the company, you further agree and accept that company shall have full rights, remedies against you that may be breach, infringement of this clause or any other clause in this appointment letter, company shall proceed against you to enforce such a right or remedy.
              </p>
            </li>
            <li>
              <h5>11. POST TERMINATION OBLIGATIONS</h5>
              <p>Upon termination of your employment with the company for any reason, you will promptly return  to the Company any keys, credit cards, identity cards, passes, notebooks, notes, confidential documents, particulars related to Company Policies, correspondence, material, or other property belongs to the Company, and return all writing files, records, correspondence, notebooks notes and other documents and things (including any copies thereof) containing Confidential, Information (as defined in the Annexure of Standard Terms and Conditions) or relating to the business of the Company or its clients, subsidiaries or affiliates. The Company reserves the right not to relieve you from your employment in the event that all the above particulars have not been properly handed over by you to a representative of the Company.
              </p>
            </li>
          </ul>
        </section>
        <br>
       <section class="border mx-2 px-5 py-3">
          <ul>
            <li>
              <h5>12. JURISDICTION</h5>
              <p>Subject to provision of code of conduct, the courts of Mohali shall have jurisdiction with respect to this letter of offer and other matters relating to your employment with the company.
              </p>
            </li>
            <li>
              <p><b>13.</b> You acknowledges and agrees with the Company that your activities have a direct bearing on the Company’s goodwill and therefore you shall not within a radius of 200 miles from the Company place of business be directly or indirectly interested, engaged or concerned or in any other way assist (whether as principal, partner, shareholder, director, agent, employee, contractor, consultant, trustee, beneficiary or otherwise) in Outsourcing Business that has similar business with the Company for a period of 3 years commencing from the date on which either party gives or receives notice terminating the Employment Agreement and whether or not you physically continues to work for the company thereafter.</p>
            </li>
            <li>
              <p><b>14.</b> You acknowledge and agree with the Company that you will not:</p>
              <ul>
                <li>(a) Directly or indirectly canvass, solicit or attempt to solicit, serve or act for any person, firm, corporation who or which has been past, present or perspective client of the Employer in any work that is of the same or similar nature as that which the Employee undertook or performed for or was done by the Employer or by any other employee or contractor of the Employer for a period of 3 years commencing from the day after the Employee’s</li>
                <li>(b) Employment actually ceasing or the day after any period of notice of termination as required by the Employment Agreement has ended, whichever is the latter; nor</li>
                <li>(c) Employ or offer employment or cause employment or any other engagement or arrangement to be offered to any person who was an employee or contractor of the Employer at any time in the 5 year period prior to the Employee’s employment actually ceasing or the day after any period of notice of termination as required by the Employment Agreement has ended, whichever is the latter.</li>
                <li>(d) If the employee is in breach of any of the conditions in this agreement, the Employee not only shall be liable to pay to the Employer by way of liquidated damages of Rs. Two Lakhs together with the amount earned by the employee while working but shall also be liable for criminal proceedings as warranted by law under the Indian Penal Code and Information technology Act for Data theft, cheating, committing fraud and criminal breach of trust.</li>
              </ul>
            </li>
            <li>
              <p><b>15.</b> You will be governed by the Companies rules and regulation (as well as practice) as enforced from time to time. In respect or matter not covered by this letter of appointment. Company’s decision on all such matter shall be final & binding on you.</p>
            </li>
            <li>
              <p><b>16.</b> Violation of any clause of this appointment will attract penalty and termination.</p>
            </li>
            <li>
              <p><b>17.</b> In case of any dispute or difference arising out of implementation or interpretation of any clause of the agreement, it will be endeavored to be settled by mutual negotiations failing which the matter shall be referred to the sole arbitrator i.e Managing Director, XEAM Ventures Private Limited (within one month of dispute) whose decision shall be final and binding on both the parties.</p>
            </li>
            <li>
              <p><b>18.</b> You can apply for any claims/dues/pending salaries within 15 (Fifteen) days of the successful completion of the work or completion of notice period in case of resignation, no claims will be entertained afterwards and company will not be responsible for any kind of dues.</p>
            </li>
            <li>
              <p><b>19.</b> Experience Certificate shall be issued only in case of completion of minimum six months tenure and can be claimed within one month of relieving from duty & can be issued only if performance is satisfactory.</p>
            </li>
            <li>
              <p><b>20.</b> During the period of employment, your services can be deputed to any of our client’s company at the sole discretion of the Management of our company to do work pertaining to or incidental our client’s business.</p>
            </li>
            <li>
              <p><b>21.</b> You are required to undergo police verification and the report to this must be submitted within 15 days of your appointment.</p>
            </li>
            <li>
              <h5>RULES OF CONFIDENTIALITY (Annexure A)</h5>
            </li>
            <br>
            <li>
              <h5>OWNERSHIP OF INTELLECTUAL PROPERTY, INVENTION ETC (Annexure B)</h5>
            </li>
            <br>
            <li>
              <h5>WORK PLACE VIOLANCE (Annexure C)</h5>
            </li>
            <br>
            <li>
              <h5>REMUNERATION (Annexure D)</h5>
            </li>
            <br>
            <p>We solicit your cooperation in following the terms and conditions mentioned above and appreciate your decision for joining our company. We look forward to your joining as a member of our team and are confident that your employment with the company will prove mutually beneficial & rewarding.</p>
          </ul>
          <div class="row justify-content-around my-5">
            <span><b>Yours Sincerely,</b></span>
            <span><b>Accepted</b></span>
          </div> 
          <br>
          <div class="row justify-content-around my-2">
            <span><b>Xeam Ventures Pvt. Ltd.</b></span>
            <span><b>Employee Signature</b></span>
          </div>
      </section>
      <br>
      <section class="border mx-2 px-5 py-3">
        <div class="my-5 py-5">
          <br><br><br><br><br><br><br><br><br><br><br><br>
          <h5 class="text-center my-4" style="font-size: 30px;">DECLARATION & CONFIRMATION OF ACCEPTANCE</h5>
          <p><b>I,</b> Mr. Daljeet Singh hereby declare and confirm that I have read and fully understood all the terms & conditions of this appointment letter and the attached annexure and schedule, and I accept the same. I confirm that all testimonials and information provided by me to Company are true and accurate. I also confirm that I am not subject to/party to any covenants, agreements or restrictions, including, without limitation, any covenants, agreements or restrictions or arising out of my prior employment or independent contractor relationships which would be breached or violated by my acceptance of employment with the company or which may interfere with the terms of my employment with the Company/the performance of my duties and obligations under my employment.
          </p>

          <p>I also confirm and declare that I am not involved in any criminal activities and have never been engaged in any criminal or anti-social activities. That I have never been convicted or charged under the Law for any criminal offence and neither any criminal case nor inquiry/proceedings are pending against me before any authority in India or any court of law. I the undersigned, hereby confirm that all information detailed above and supplied by me on the basis of which I am being offered employment is accurate. I understand that Xeam Ventures Pvt. Ltd. reserves the right to remove any employee from the Company immediately or invoke such legal action against such employee should that employee fail to declare any Criminal Convictions, Cautions, reprimands and/or Warnings. I understand that false declaration would be an offence and may lead to immediate removal from the Company.</p>
          <br><br>
          <div class="signature-box">
            <div class="signature-box-content">
              <div><b>Signature:</b> <span>........................................................</span></div><br>
              <div><b>[ Name ]</b></div><br>
              <div><b>[Address ]</b></div>
            </div>
          </div>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      </section>

      <br>
      <section class="border mx-2 px-5 py-3">
        <div class="my-5 py-5">
          <br><br><br><br><br><br><br><br><br><br><br>
          <h5 class="text-right"><b>Annexure A</b></h5>
          <br><br>
          <h5 class="text-center my-4" style="font-size: 30px;">RULES OF CONFIDENTIALITY</h5>
          <p><b>1.</b> During your employment with the Company and thereafter your will, at all times, hold strictest confidence and use, except for the benefit of the company, or disclose to any person, firm or corporation without written authorization of the Board of Directors of the Company any Confidential Information of the Company or related corporations or of the clients or customers or the Company. You will understand that Confidential Information, means propriety information of the Company or any related corporation or clients or technical data, trade secrets or know how, including but not limited to users or potential users of the company’s products/services on whom you may cal or with whom you may become acquainted during the terms of your employment), overseas, business associates and other business relationships, market software developments, inventions processes, formulae, technology, designs, drawings, engineering, hardware configuration information, marketing finance or any other either directly or indirectly in writing. orally or by drawing or inspection of parts or equipment, you will also be responsible for the protection and furtherance or inspections of parts or equipment.
          </p>

          <p><b>2.</b> You will also be responsible for the protection and furtherance of the Company’s best interest at all times, including after you cease to be on the company’s role.</p>
          <br><br>
          <div class="signature-box">
            <div class="signature-box-content">
              <div><b>Signature:</b> <span>........................................................</span></div><br>
              <div><b>[ Name ]</b></div><br>
              <div><b>[Address ]</b></div>
            </div>
          </div>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      </section>

      <br>
      <section class="border mx-2 px-5 py-3">
        <div class="my-5 py-5">
          <br><br><br><br><br><br><br><br><br><br><br>
          <h5 class="text-right"><b>Annexure B</b></h5>
          <br><br>
          <h5 class="text-center my-4" style="font-size: 30px;">OWNERSHIP OF INTELLECTUAL PROPERTY, INVENTION ETC.</h5>
          <p class="mb-4">During the course of your employment (or outside working hours if you are using Company’s premises or equipment) all inventions, discoveries and novel designs whether or not register-able as design or patents, all writings including programs, art works and other copyright works crated by you belong  to the company, In addition to disclosing any inventions, discoveries design of copyright works you shall disclose and if required by the company, assign the  Company any other inventions, discoveries, designs or copyright works devised or created by you during your employment which relate to or touch upon the future or present business or products of the company or its related associates or affiliates or subsidiaries. You shall during the course of your employment do all such acts and things, and sign all documents, as the company or its Attorneys may reasonably request to secure the company’s ownership or rights to such inventions, discoveries, designs and copyright works.
          </p>
          <br><br>
          <div class="signature-box">
            <div class="signature-box-content">
              <div><b>Signature:</b> <span>........................................................</span></div><br>
              <div><b>[ Name ]</b></div><br>
              <div><b>[Address ]</b></div>
            </div>
          </div>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      </section>
      <br>
      <section class="border mx-2 px-5 py-3">
        <div class="my-5 py-5">
          <br><br><br><br><br><br><br><br><br><br>
          <h5 class="text-right"><b>Annexure C</b></h5>
          <br><br>
          <h5 class="text-center my-4" style="font-size: 30px;">WORK PLACE VIOLANCE</h5>
          <p>The Human Resources and Administration Departments would prevent/ or respond to incidents of workplace violence or a perceived threat of violence in the workplace.</p>
          <p>Any sort if violence, exchange of threatening words, etc among the Xeam employees; any conversation that engages verbal threats or physical actions that may create a security hazard for others in the workplace will be taken seriously and is thoroughly and promptly </p>investigated.
          <p>Few activities are prohibited in the office premises because they clearly are not conducive to a good work environment. Employees who engage in any of these prohibited activities are subject to disciplinary action, up to and including dismissal. These activities include;</p>
          <ul>
            <li>1) threats or violent behavior;</li>
            <li>2) Sexual harassment;</li>
            <li>3) possession of weapons of any type;</li>
            <li>4) use, distribution, sale or possession of illegal drugs or any other controlled substance;</li>
          </ul>
          <p>It is ensured that any sort of violence in the workplace will be given prompt reaction which may also lead to termination of Employment of the Employee.</p>
          <br><br>
          <div class="signature-box">
            <div class="signature-box-content">
              <div><b>Signature:</b> <span>........................................................</span></div><br>
              <div><b>[ Name ]</b></div><br>
              <div><b>[Address ]</b></div>
            </div>
          </div>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      </section>
  </body>
</html>