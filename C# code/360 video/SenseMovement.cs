using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.IO;
using System.Windows;
using System.Windows.Media;
using Microsoft.Kinect;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;
using System.Globalization;
using System.Threading;
using System.Windows.Threading;

namespace Microsoft.Samples.Kinect.SpeechBasics
{
    public class SenseMovement
    {

        TelnetConnection tc;
        SendMovement send;

        /// <summary>
        /// Width of output drawing
        /// </summary>
        private const float RenderWidth = 640.0f;

        /// <summary>
        /// Height of our output drawing
        /// </summary>
        private const float RenderHeight = 480.0f;

        /// <summary>
        /// Thickness of body center ellipse
        /// </summary>
        private const double BodyCenterThickness = 10;

        /// <summary>
        /// Brush used to draw skeleton center point
        /// </summary>
        private readonly System.Windows.Media.Brush centerPointBrush = System.Windows.Media.Brushes.Blue;

        /// <summary>
        /// Active Kinect sensor
        /// </summary>
        private KinectSensor sensor;

        /// <summary>
        /// Drawing group for skeleton rendering output
        /// </summary>
        private DrawingGroup drawingGroup;

        public SenseMovement(TelnetConnection tc)
        {
            this.tc = tc;
            send = new SendMovement(tc);
        }

        public void Start()
        {
            StartSensor();
        }

        /// <summary>
        /// Execute startup tasks
        /// </summary>
        /// <param name="sender">object sending the event</param>
        /// <param name="e">event arguments</param>
        private void StartSensor()
        {
            // Create the drawing group we'll use for drawing
            this.drawingGroup = new DrawingGroup();

            // Look through all sensors and start the first connected one.
            // This requires that a Kinect is connected at the time of app startup.
            // To make your app robust against plug/unplug, 
            // it is recommended to use KinectSensorChooser provided in Microsoft.Kinect.Toolkit (See components in Toolkit Browser).
            foreach (var potentialSensor in KinectSensor.KinectSensors)
            {
                if (potentialSensor.Status == KinectStatus.Connected)
                {
                    this.sensor = potentialSensor;
                    break;
                }
            }

            if (null != this.sensor)
            {
                // Turn on the skeleton stream to receive skeleton frames
                this.sensor.SkeletonStream.Enable();

                // Add an event handler to be called whenever there is new color frame data
                this.sensor.SkeletonFrameReady += this.SensorSkeletonFrameReady;

                // Start the sensor!
                try
                {
                    this.sensor.Start();
                }
                catch (IOException)
                {
                    this.sensor = null;
                }
            }

            if (null == this.sensor)
            {
                // this.statusBarText.Text = Properties.Resources.NoKinectReady;
            }
        }

        /// <summary>
        /// Execute shutdown tasks
        /// </summary>
        /// <param name="sender">object sending the event</param>
        /// <param name="e">event arguments</param>
        private void WindowClosing(object sender, System.ComponentModel.CancelEventArgs e)
        {
            if (null != this.sensor)
            {
                this.sensor.Stop();
            }
        }

        /// <summary>
        /// Event handler for Kinect sensor's SkeletonFrameReady event
        /// </summary>
        /// <param name="sender">object sending the event</param>
        /// <param name="e">event arguments</param>
        private void SensorSkeletonFrameReady(object sender, SkeletonFrameReadyEventArgs e)
        {
            Skeleton[] skeletons = new Skeleton[0];

            using (SkeletonFrame skeletonFrame = e.OpenSkeletonFrame())
            {
                if (skeletonFrame != null)
                {
                    skeletons = new Skeleton[skeletonFrame.SkeletonArrayLength];
                    skeletonFrame.CopySkeletonDataTo(skeletons);
                }
            }

            using (DrawingContext dc = this.drawingGroup.Open())
            {
                if (skeletons.Length != 0)
                {
                    foreach (Skeleton skel in skeletons)
                    {
                        if (skel.TrackingState == SkeletonTrackingState.Tracked)
                        {
                            this.CheckDirection(skel, dc);
                        }
                        else if (skel.TrackingState == SkeletonTrackingState.PositionOnly)
                        {
                            dc.DrawEllipse(
                            this.centerPointBrush,
                            null,
                            this.SkeletonPointToScreen(skel.Position),
                            BodyCenterThickness,
                            BodyCenterThickness);
                        }
                    }
                }

                // prevent drawing outside of our render area
                this.drawingGroup.ClipGeometry = new RectangleGeometry(new Rect(0.0, 0.0, RenderWidth, RenderHeight));
            }
        }


        /// <summary>
        /// Maps a SkeletonPoint to lie within our render space and converts to Point
        /// </summary>
        /// <param name="skelpoint">point to map</param>
        /// <returns>mapped point</returns>
        private System.Windows.Point SkeletonPointToScreen(SkeletonPoint skelpoint)
        {
            // Convert point to depth space.  
            // We are not using depth directly, but we do want the points in our 640x480 output resolution.
            DepthImagePoint depthPoint = this.sensor.CoordinateMapper.MapSkeletonPointToDepthPoint(skelpoint, DepthImageFormat.Resolution640x480Fps30);
            return new System.Windows.Point(depthPoint.X, depthPoint.Y);
        }

        public static DateTime lastHit = new DateTime();
        public static Boolean mSend = false;
        /// <summary>
        /// Custom function - check direction hands
        /// </summary>
        /// <param name="skeleton">skeleton to draw</param>
        /// <param name="drawingContext">drawing context to draw to</param>
        private void CheckDirection(Skeleton skeleton, DrawingContext drawingContext)
        {
            System.Windows.Point handLeft = new System.Windows.Point(skeleton.Joints[JointType.HandLeft].Position.X, skeleton.Joints[JointType.HandLeft].Position.Y);
            System.Windows.Point handRight = new System.Windows.Point(skeleton.Joints[JointType.HandRight].Position.X, skeleton.Joints[JointType.HandRight].Position.Y);
            System.Windows.Point hipCenter = new System.Windows.Point(skeleton.Joints[JointType.HipCenter].Position.X, skeleton.Joints[JointType.HipCenter].Position.Y);
            Thread t1 = new Thread(delegate()
            {
                send.TelnetChar("R");
            });
            Thread t2 = new Thread(delegate()
            {
                send.TelnetChar("L");
            });
            Thread t3 = new Thread(delegate()
            {
                send.TelnetChar("M");
            });

            /*
             *  Met deze code zal hij max 2/3 keer per seconde een L/R sturen
             *  En na 10 seconden in activiteit stuurt hij een M
             */

            if (handLeft.X <= hipCenter.X - 0.4 && lastHit.Add(new System.TimeSpan(0, 0, 0, 0, 500)) <= DateTime.Now)
            {
                t2.Start();
                lastHit = DateTime.Now;
                mSend = false;
            }

            if (handRight.X >= hipCenter.X + 0.4 && lastHit.Add(new System.TimeSpan(0, 0, 0, 0, 500)) <= DateTime.Now)
            {
                t1.Start();
                lastHit = DateTime.Now;
                mSend = false;
            }

            if (lastHit.Add(new System.TimeSpan(0, 0, 10)) <= DateTime.Now && !mSend)
            {
                t3.Start();
                lastHit = DateTime.Now;
                mSend = true;
            }
        }
    }
}
